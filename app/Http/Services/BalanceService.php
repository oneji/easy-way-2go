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
        $balance = [];
        $debts = [];

        if($user->role === 'brigadir') {
            // Get all user drivers
            $drivers = Driver::whereBrigadirId($user->id)->pluck('id');
            // Get all user transport by driver ids
            $transport = DB::table('driver_transport')
                ->join('transports', 'transports.id', 'driver_transport.transport_id')
                ->select('transports.*')
                ->whereIn('driver_id', $drivers)
                ->get();

            $balance = $transport->unique()->sum('balance');
            $debts = Order::where('payment_status_id', PaymentStatus::getNotPaid()->id)
                ->whereIn('transport_id', $transport->pluck('id'))
                ->sum('total_price');
        }

        return [
            'success' => true,
            'balance' => $balance,
            'debts' => $debts
        ];
    }
}