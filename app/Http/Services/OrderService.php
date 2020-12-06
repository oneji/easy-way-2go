<?php

namespace App\Http\Services;

use App\Http\JsonRequests\StoreOrderRequest;
use App\Http\Services\PassengerService;
use App\Http\Services\PackageService;
use Carbon\Carbon;
use App\Package;
use App\Order;

class OrderService
{
    /**
     * Get client's orders
     */
    public function getClientOrders()
    {
        $client = auth('client')->user();

        return Order::with([ 'country_from', 'country_to' ])->where('client_id', $client->id)->get();
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
        return Order::with([ 'country_from', 'country_to' ])
            ->whereId($id)
            ->first();
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
        $order->status = 'future';
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
}