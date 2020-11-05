<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
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
            'ok' => true,
            'route' => $route
        ]);
    }

    /**
     * Store a newly created route
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'addresses' => 'required',
            'repeats' => 'required',
            'addresses.*.country_id' => [ 'required', 'exists:countries,id' ],
            'addresses.*.address' => [ 'required', 'string' ],
            'addresses.*.departure_date' => [ 'required', 'date' ],
            'addresses.*.departure_time' => [ 'required', 'string' ],
            'addresses.*.arrival_date' => [ 'required', 'date' ],
            'addresses.*.arrival_time' => [ 'required', 'string' ],
            'addresses.*.type' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'ok' => false,
                'errors' => $validator->errors()
            ]);
        }

        $this->routeService->store($request);

        return response()->json([
            'ok' => true
        ]);
    }
}
