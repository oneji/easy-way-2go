<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Route;

class RouteService
{
    /**
     * Store a newly created route
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $route = new Route($request->all());
        $route->departure_date = Carbon::parse($request->departure_date);
        $route->arrival_date = Carbon::parse($request->arrival_date);
        $route->user_id = auth('api')->user()->id;
        $route->save();
    }
}