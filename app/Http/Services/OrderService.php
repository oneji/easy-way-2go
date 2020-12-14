<?php

namespace App\Http\Services;

use App\Http\JsonRequests\CancelOrderRequest;
use App\Http\JsonRequests\StoreOrderRequest;
use App\Http\Services\PassengerService;
use App\Http\Services\PackageService;
use Carbon\Carbon;
use App\Package;
use App\Order;
use App\OrderStatus;
use Illuminate\Http\Request;

class OrderService
{
    /**
     * Get client's orders
     */
    public function getClientOrders(Request $request)
    {
        $client = auth('client')->user();
        // Filtering params
        $id = $request->query('id');
        $type = $request->query('type');
        $from = $request->query('from');
        $to = $request->query('to');

        return Order::with([ 'country_from', 'country_to', 'moving_data', 'transport' ])
            ->leftJoin('moving_data', 'moving_data.order_id', 'orders.id')
            ->select(
                'orders.*',
                'moving_data.from_floor',
                'moving_data.to_floor',
                'moving_data.time',
                'moving_data.movers_count',
                'moving_data.parking',
                'moving_data.parking_working_hours'
            )
            ->when($id, function($query, $id) {
                $query->where('id', 'like', "%$id%");
            })
            ->when($type, function($query, $type) {
                $query->where('order_type', $type);
            })
            ->when($from, function($query, $from) {
                $query->where('date', '>=', Carbon::parse($from));
            })
            ->when($to, function($query, $to) {
                $query->where('date', '<=', Carbon::parse($to));
            })
            ->where('client_id', $client->id)
            ->get();
    }

    /**
     * Get all orders
     * 
     * @return collection
     */
    public function all()
    {
        return Order::with([ 'country_from', 'country_to' ])->get();
    }

    /**
     * Get a specific order
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return Order::with([ 'country_from', 'country_to', 'cargos' ])
            ->leftJoin('moving_data', 'moving_data.order_id', 'orders.id')
            ->select(
                'orders.*',
                'moving_data.from_floor',
                'moving_data.to_floor',
                'moving_data.time',
                'moving_data.movers_count',
                'moving_data.parking',
                'moving_data.parking_working_hours'
            )
            ->find($id);
    }

    /**
     * Store a newly created order
     * 
     * @param \App\Http\JsonRequests\StoreOrderRequest $request
     */
    public function store(StoreOrderRequest $request)
    {
        $order = new Order($request->all());
        $order->date = Carbon::parse($request->date);
        $order->client_id = auth('client')->user()->id;
        $order->order_status_id = OrderStatus::getFuture()->id;
        $order->save();

        if($order->order_type === 'moving') {
            // Save moving data
            MovingDataService::store([
                'from_floor' => $request->from_floor,
                'to_floor' => $request->to_floor,
                'time' => $request->time,
                'movers_count' => $request->movers_count,
                'parking' => $request->parking,
                'parking_working_hours' => $request->parking_working_hours,
                'order_id' => $order->id,
                'cargos' => $request->cargos
            ]);
        } else {
            if(isset($request->passengers)) {
                PassengerService::attachToOrder($request->passengers, $order->id);
            }
    
            if(isset($request->package_dimensions_type)) {
                if($request->package_dimensions_type === Package::TYPE_SAME) {
                    PackageService::attachSameToOrder($request->package, $request->packages_count, $order->id);
                } else {
                    PackageService::attachDifferentToOrder($request->packages, $order->id);
                }
            }
        }

        return $order;
    }

    /**
     * Cancel order
     * 
     * @param \App\Http\JsonRequests\CancelOrderRequest
     */
    public function cancel(CancelOrderRequest $request)
    {
        $order = Order::find($request->order_id);
        $order->order_status_id = OrderStatus::getCancelled()->id;
        $order->cancellation_reason = $request->reason;
        $order->save();

        return $order;
    }
}