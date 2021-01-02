<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\StatsService;

class StatsController extends Controller
{
    protected $service;

    /**
     * StatsController constructor
     * 
     * @param \App\Http\Services\StatsService $service
     */
    public function __construct(StatsService $service)
    {
        $this->service = $service;
    }

    /**
     * Stats total
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function getTotal(Request $request)
    {
        $data = $this->service->getTotal($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Stats by bus
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByBus(Request $request)
    {
        $data = $this->service->getByBus($request);

        return response()->json([
            'success' => true,
            'data' => $data 
        ]);
    }
}
