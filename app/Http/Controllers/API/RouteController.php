<?php

namespace App\Http\Controllers\API;

use App\Http\JsonRequests\SearchRouteRequest;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\StoreRouteRequest;
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
     * Get a specific route by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $route = $this->routeService->getById($id);

        return response()->json([
            'success' => true,
            'data' => $route
        ]);
    }

    /**
     * Store a newly created route
     * 
     * @param   \App\Http\JsonRequests\StoreRouteRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function store(StoreRouteRequest $request)
    {
        $data = $this->routeService->store($request);

        return response()->json($data);
    }

    /**
     * Searching for routes
     * 
     * @param \App\Http\JsonRequests\SearchRouteRequest $request
     */
    public function search(SearchRouteRequest $request)
    {
        $routes = $this->routeService->search($request);

        return response()->json([
            'success' => true,
            'data' => $routes
        ]);
    }

    /**
     * Archive route
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive($id)
    {
        $data = $this->routeService->archive($id);
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]); 
    }
}
