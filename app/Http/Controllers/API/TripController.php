<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\TripService;

class TripController extends Controller
{
    private $tripService;

    /**
     * TripController constructor
     * 
     * @param \App\Http\Service\TripService $tripService
     */
    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }

    /**
     * Get all available trips
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $data = $this->tripService->all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
