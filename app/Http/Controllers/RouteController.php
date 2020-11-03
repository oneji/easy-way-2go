<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\RouteService;

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

        return view('routes.index', [
            'routes' => $routes
        ]);
    }
}
