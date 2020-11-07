<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\RouteRepeat;
use App\RouteAddress;
use App\Route;

class RouteService
{
    /**
     * Get all routes with address and repeats
     * 
     * @return collection
     */
    public function all()
    {
        return Route::with([ 'route_addresses', 'route_repeats' ])->get();
    }

    /**
     * Get all routes with addresses and repeats paginated
     */
    public function getPaginated()
    {
        return Route::with([ 'route_addresses', 'driver' ])->paginate(10);
    }

    /**
     * Get a specific route by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return Route::with([ 'route_addresses', 'route_repeats', 'driver' ])->where('id', $id)->first();
    }

    /**
     * Store a newly created route
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $route = new Route();
        $route->driver_id = $request->driver_id;
        $route->save();

        // Save route addresses
        foreach ($request->addresses as $address) {
            $route->route_addresses()->save(new RouteAddress([
                'country_id' => $address['country_id'],
                'address' => $address['address'],
                'departure_date' => Carbon::parse($address['departure_date']),
                'departure_time' => $address['departure_time'],
                'arrival_date' => Carbon::parse($address['arrival_date']),
                'arrival_time' => $address['arrival_time'],
                'type' => $address['type'],
            ]));
        }

        // Save route repeats
        foreach ($request->repeats as $repeat) {
            $route->route_repeats()->save(new RouteRepeat([
                'from' => Carbon::parse($repeat['from']),
                'to' => Carbon::parse($repeat['to']),
            ]));
        }
    }
}