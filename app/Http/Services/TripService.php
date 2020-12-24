<?php

namespace App\Http\Services;

use App\Route;
use App\Trip;

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
}