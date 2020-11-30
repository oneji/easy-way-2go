<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\JsonRequests\SearchRouteRequest;
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
        return Route::with([ 'route_addresses', 'transport' ])->paginate(10);
    }

    /**
     * Get a specific route by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return Route::with([ 'route_addresses', 'route_repeats', 'transport' ])->where('id', $id)->first();
    }

    /**
     * Store a newly created route
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $route = new Route();
        $route->transport_id = $request->transport_id;
        $route->save();

        // dd($request->addresses);

        // Save route addresses
        foreach ($request->addresses as $address) {
            $route->route_addresses()->save(new RouteAddress([
                'country_id' => $address['country_id'],
                'address' => $address['address'],
                'place_id'=> $address['place_id'],
                'departure_date' => Carbon::parse($address['departure_date']),
                'departure_time' => $address['departure_time'],
                'arrival_date' => Carbon::parse($address['arrival_date']),
                'arrival_time' => $address['arrival_time'],
                'type' => $address['type'],
                'order' => $address['order']
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

    /**
     * Searching for routes
     * 
     * @param \App\Http\JsonRequests\SearchRouteRequest $request
     */
    public function search(SearchRouteRequest $request)
    {
        $routes = Route::all();
        
        foreach ($routes as $route) {
            $startings = RouteAddress::where('country_id', $request->from_country)
                ->where('place_id', 'like', "%$request->from_address%")
                ->where('departure_date', Carbon::parse($request->date))
                ->whereRouteId($route->id)
                ->get();

            $endings = RouteAddress::where('country_id', $request->to_country)
                ->where('place_id', 'like', "%$request->to_address%")
                ->where('departure_date', Carbon::parse($request->date))
                ->whereRouteId($route->id)
                ->get();
            
            $starting = null;
            $ending = null;
            $intermediates = null;
            foreach ($startings as $item) {
                foreach ($endings as $endItem) {
                    if($item->type === $endItem->type && $item->order < $endItem->order) {
                        $starting = $item;
                        $ending = $endItem;
                    }
                }
            }

            // return [
            //     'starting' => $starting,
            //     'ending' => $ending,
            // ];

            if($starting && $ending) {
                $intermediates = RouteAddress::whereBetween('order', [ $starting->order, $ending->order ])
                    ->whereNotIn('id', [$starting->id, $ending->id])
                    ->whereRouteId($route->id)
                    ->whereType($starting->type)
                    ->orderBy('order')
                    ->get();

                    $route['addresses'] = $intermediates->prepend($starting)->push($ending);
            }

            // return [
            //     'starting' => $starting,
            //     'ending' => $ending,
            //     'intermediates' => $intermediates
            // ];
        }

        return $routes;
    }
}