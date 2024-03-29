<?php

namespace App\Http\Services;

use App\Http\JsonRequests\StoreRouteRequest;
use App\Http\JsonRequests\SearchRouteRequest;
use App\OrderStatus;
use Carbon\Carbon;
use App\RouteRepeat;
use App\RouteAddress;
use App\Route;
use App\Trip;
use Illuminate\Support\Facades\DB;

class RouteService
{
    protected $tripService;

    /**
     * Create a new intance of RouteService class
     * 
     * @param \App\Http\Services\TripService $tripService
     */
    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }

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
     * @param \App\Http\JsonRequests\SearchRouteRequest $request
     */
    public function store(StoreRouteRequest $request)
    {
        $route = new Route();
        $route->transport_id = $request->transport_id;
        $route->save();

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

        // Create a trip for the route
        $trip = new Trip();
        $trip->route_id = $route->id;
        $trip->transport_id = $route->transport_id;
        $trip->status_id = OrderStatus::getFuture()->id;
        $trip->type = 'forward';
        $trip->save();

        $tripData = $route->getDataForTrip($trip->id);

        if(count($tripData) > 0) {
            DB::table('trip_data')->insert($tripData);
        }

        return [
            'success' => true,
            'message' => 'You have successfully created a route'
        ];
    }

    /**
     * Searching for routes
     * 
     * @param \App\Http\JsonRequests\SearchRouteRequest $request
     */
    public function search(SearchRouteRequest $request)
    {
        $data = $request->all();
        // First load route addresses to decrease queries to the DB 
        $routes = Route::with([ 'route_addresses', 'transport' ])->get();
        
        $newRoutes = [];
        foreach ($routes as $route) {
            $startings = $route->route_addresses->filter(function($value) use ($data) {
                return $value['place_id'] === $data['from_address']
                    && (int) $value['country_id'] === (int) $data['from_country']
                    && Carbon::parse($value['departure_date']) == Carbon::parse($data['date']);
            })->values();

            $endings = $route->route_addresses->filter(function($value) use ($data) {
                return $value['place_id'] === $data['to_address']
                    && (int) $value['country_id'] === (int) $data['to_country']
                    && Carbon::parse($value['departure_date']) == Carbon::parse($data['date']);
            })->values();
            
            $starting = null;
            $ending = null;
            foreach ($startings as $item) {
                foreach ($endings as $endItem) {
                    if($item->type === $endItem->type && $item->order < $endItem->order) {
                        $starting = $item;
                        $ending = $endItem;
                    }
                }
            }

            $intermediates = null;
            if($starting && $ending) {
                $intermediates = $route->route_addresses->whereBetween('order', [ $starting->order, $ending->order ])
                    ->whereNotIn('id', [$starting->id, $ending->id])
                    ->where('type', $starting->type)
                    ->sortBy('order');

                $route['addresses'] = $intermediates->prepend($starting)->push($ending);
                // Unset route addresses array cz we now have a new filtered one...
                $route->unsetRelation('route_addresses');

                if($intermediates->count() > 0) {
                    $newRoutes[] = $route;
                }
            }
        }

        return $newRoutes;
    }

    /**
     * Archive route
     * 
     * @param int $id
     * @return Route $route
     */
    public function archive($id)
    {
        $route = Route::find($id);
        $route->status = 'archive';
        $route->save();

        return $route;
    }
}