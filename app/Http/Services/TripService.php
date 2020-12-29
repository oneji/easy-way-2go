<?php

namespace App\Http\Services;

use App\Http\JsonRequests\CancelTripRequest;
use App\OrderStatus;
use App\Route;
use App\Trip;
use Illuminate\Support\Facades\DB;

class TripService
{
    /**
     * Get all available trips
     * 
     * @return collection
     */
    public function all()
    {
        return Trip::with([ 'from_country', 'to_country' ])->get();
    }
    /**
     * Store a newly created trip
     * 
     * @param array $tripData
     */
    public function findOrCreate($tripData)
    {
        $trip = Trip::where([
            'transport_id' => $tripData['transport_id'],
            'route_id' => $tripData['route_id'],
            'date' => $tripData['date']
        ])->first();

        if($trip) return $trip;
        
        $route = Route::find($tripData['route_id']);
        $trip = new Trip($tripData);
        $trip->type = 'forward';
        $trip->from_address = $route->getCitiesByType('forward')['first']['address'];
        $trip->to_address = $route->getCitiesByType('forward')['last']['address'];
        $trip->save();

        return $trip;
    }

    /**
     * Set trip's drivers
     * 
     * @param int $id
     * @param int $driverId
     */
    public function setDriver($id, $driverId)
    {
        DB::table('driver_trip')->insert([
            'driver_id' => $driverId,
            'trip_id' => $id,
        ]);
    }

    /**
     * Set new tranport
     * 
     * @param int $id
     * @param int $transportId
     */
    public function setNewTransport($id, $transportId)
    {
        $trip = Trip::with('orders')->find($id);
        $trip->transport_id = $transportId;
        $trip->save();

        foreach ($trip->orders as $order) {
            $order->transport_id = $transportId;
            $order->save();
        }
    }

    /**
     * Cancel trip
     * 
     * @param \App\Http\JsonRequests\CancelTripRequest
     */
    public function cancel(CancelTripRequest $request)
    {
        $trip = Trip::find($request->trip_id);
        $trip->status_id = OrderStatus::getCancelled()->id;
        $trip->cancellation_reason = $request->reason;
        $trip->save();

        return $trip;
    }

    /**
     * Finish 1/2 of the trip
     * 
     * @param int $id
     */
    public function finishHalf($id)
    {
        $trip = Trip::find($id);
    }
}