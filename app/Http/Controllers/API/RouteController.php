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
     * Store a newly created route
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => [ 'required', 'exists:countries,id' ],
            'address' => [ 'required', 'string' ],
            'departure_date' => [ 'required', 'date' ],
            'departure_time' => [ 'required', 'string' ],
            'arrival_date' => [ 'required', 'date' ],
            'arrival_time' => [ 'required', 'string' ],
            'type' => 'required'
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
