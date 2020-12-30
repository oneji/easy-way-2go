<?php

namespace App\Http\Services;

use App\Driver;
use App\Order;
use App\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebtService
{
    /**
     * Get all user debts
     * 
     * @return collection
     */
    public function all(Request $request)
    {
        // Filtering params
        $carNumber = $request->query('car_number');
        $user = $request->authUser;
        $transport = null;

        if($user->role === 'driver') {
            $transport = DB::table('driver_transport')->whereDriverId($user->id)->pluck('transport_id');
        } elseif($user->role === 'brigadir') {
        //     // Get all user drivers
            $drivers = Driver::whereBrigadirId($user->id)->pluck('id');
            // Get all user transport by driver ids
            $transport = DB::table('driver_transport')
                ->join('transports', 'transports.id', 'driver_transport.transport_id')
                ->select('transports.*')
                ->where('transports.car_number', 'like', "%$carNumber%")
                ->whereIn('driver_id', $drivers)
                ->pluck('id');
        }

        $debts = Order::join('clients', 'clients.id', 'orders.client_id')
            ->join('transports', 'transports.id', 'orders.transport_id')
            ->where('payment_status_id', PaymentStatus::getNotPaid()->id)
            ->whereIn('transport_id', $transport)
            ->get([
                'orders.id',
                'clients.first_name',
                'clients.last_name',
                'transports.car_number',
                'orders.total_price as debt_amount',
                'clients.phone_number',
                'clients.email'
            ]);

        return $debts;
    }
}