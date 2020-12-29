<?php

namespace App\Http\Services;

use App\Http\JsonRequests\CancelTripRequest;
use App\Order;
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

    /**
     * Change trips direction
     * 
     * @param int $id
     * @param string $direction
     */
    public function changeDirection($id, $direction)
    {
        $trip = Trip::with([ 'from_country', 'to_country', 'status' ])
            ->leftJoin('transports', 'transports.id', 'trips.transport_id')
            ->select(
                'trips.id',
                'transports.car_number',
                'transports.passengers_seats',
                'transports.cubo_metres_available',
                'transports.kilos_available',
                'trips.date',
                'trips.time',
                'trips.from_address',
                'trips.to_address',
                'trips.type',
                'trips.status_id',
                'trips.from_country_id',
                'trips.to_country_id'
            )
            ->where('trips.id', $id)
            ->first();
        $trip->type = $direction;
        $trip->save();

        // Collecton trip stats
        $stats = Order::selectRaw('
            sum(passengers_count) as passengers,
            sum(packages_count) as packages,
            sum(total_price) as total_price,
            trip_id'
        )
        ->whereHas('addresses', function($query) use ($direction) {
            $query->where('type', $direction);
        })
        ->where('trip_id', $trip->id)
        ->groupBy('trip_id')
        ->first();

        if($stats) {
            $trip['passengers'] = $stats->passengers .'/'. $trip->passengers_seats;
            $trip['packages'] = $stats->packages .'/'. $trip->cubo_metres_available;
            $trip['total_price'] = $stats->total_price;
        }

        return $trip;
    }
}