<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\JsonRequests\StoreOrderRequest;
use App\Http\Services\PassengerService;
use App\Http\Services\PackageService;
use Carbon\Carbon;
use App\Passenger;
use App\Package;
use App\Order;

class OrderService
{
    /**
     * Get all orders
     * 
     * @return collection
     */
    public function all()
    {
        $client = auth('client')->user();

        return Order::where('client_id', $client->id)->get();
    }

    /**
     * Store a newly created order
     * 
     * @param \App\Http\JsonRequests\StoreOrderRequest $request
     */
    public function store(StoreOrderRequest $request)
    {
        $order = new Order($request->except('passengers', 'packages', 'package', 'packages_count', 'package_dimensions_type'));
        $order->date = Carbon::parse($request->date);
        $order->client_id = auth('client')->user()->id;
        $order->save();

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
}