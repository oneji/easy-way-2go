<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\RouteService;
use App\Country;
use App\Transport;

class RouteController extends Controller
{
    private $routeService;

    /**
     * RouteController constructor
     * 
     * @param \App\Http\Service\RouteService $routeService
     */
    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    /**
     * Show a listing of routes
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = $this->routeService->getPaginated();

        // return $routes;

        return view('routes.index', [
            'routes' => $routes
        ]);
    }

    /**
     * Show route create form
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();
        $transports = Transport::all();

        return view('routes.create', [
            'countries' => $countries,
            'transports' => $transports
        ]);
    }
}
