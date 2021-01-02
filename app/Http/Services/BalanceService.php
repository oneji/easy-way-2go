<?php

namespace App\Http\Services;

use App\Driver;
use App\Order;
use App\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceService
{
    /**
     * Get all related to the user's balance
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function all(Request $request)
    {
        $user = $request->authUser;
        $transport = null;
        $balance = 0;
        $debts = 0;

        if($user->role === 'brigadir') {
            // Get all user transport
            $transport = Driver::join('driver_transport', 'driver_transport.driver_id', 'drivers.id')
                ->join('transports', 'transports.id', 'driver_transport.transport_id')
                ->select('transports.*')
                ->where('drivers.brigadir_id', $user->id)
                ->get();
        } else if($user->role === 'driver') {
            $transport = DB::table('driver_transport')
                ->join('transports', 'transports.id', 'driver_transport.transport_id')
                ->select('transports.*')
                ->whereDriverId($user->id)
                ->get();
        }

        $balance = $transport->unique()->sum('balance');
            $debts = Order::where('payment_status_id', PaymentStatus::getNotPaid()->id)
                ->whereIn('transport_id', $transport->pluck('id'))
                ->sum('total_price');

        return [
            'balance' => $balance,
            'debts' => $debts
        ];
    }
}