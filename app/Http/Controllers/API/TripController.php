<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\SetDriverToTripRequest;
use App\Http\JsonRequests\SetTransportToOrderRequest;
use App\Http\JsonRequests\SetTransportToTripRequest;
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

    /**
     * Set new driver to the trip
     * 
     * @param \App\Http\JsonRequests\SetDriverToTripRequest $request
     */
    public function setDriver(SetDriverToTripRequest $request)
    {
        $this->tripService->setDriver($request->trip_id, $request->driver_id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Set new transport
     * 
     * @param \App\Http\JsonRequests\SetTransportToTripRequest $request
     */
    public function setNewTransport(SetTransportToTripRequest $request)
    {
        $this->tripService->setNewTransport($request->trip_id, $request->transport_id);

        return response()->json([
            'success' => true
        ]);
    }
}
