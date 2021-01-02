<?php

namespace App\Http\Services;

use App\Driver;
use App\Order;
use App\OrderStatus;
use App\PaymentStatus;
use App\Transport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebtService
{
    protected $transactionService;

    /**
     * OrderService constructor
     * 
     * @param \App\Http\Services\TransactionService $transactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Get all user debts
     * 
     * @return collection
     */
    public function all(Request $request)
    {
        $user = $request->authUser;
        $carNumber = $request->query('car_number');
        $orderId = $request->query('order_id');

        $transport = null;
        if($user->role === 'driver') {
            $transport = DB::table('driver_transport')->whereDriverId($user->id)->pluck('transport_id');
        } elseif($user->role === 'brigadir') {
            // Get all user drivers
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
            ->where('orders.id', 'like', "%$orderId%")
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

    /**
     * Approve debt payment
     * 
     * @param int $id
     */
    public function approve($id)
    {
        $order = Order::find($id);
        $order->payment_status_id = PaymentStatus::getPaid()->id;
        $order->save();

        $transport = Transport::find($order->transport_id);
        $transport->balance += $order->total_price;
        $transport->save();

        $this->transactionService->store([
            'payment_method_id' => $order->payment_method_id,
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'type' => 'income',
            'date' => Carbon::now()
        ]);

        return [
            'success' => true,
            'message' => 'You have successfully approved payment of debt №' . $order->id
        ];
    }
}