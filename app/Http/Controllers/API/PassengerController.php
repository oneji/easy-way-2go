<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\PassengerService;
use App\Http\JsonRequests\StorePassengerRequest;
use App\Http\JsonRequests\UpdatePassengerRequest;

class PassengerController extends Controller
{
    private $passengerService;

    /**
     * PassengerController constructor
     * 
     * @param \App\Http\Services\PassengerService $passengerService
     */
    public function __construct(PassengerService $passengerService)
    {
        $this->passengerService = $passengerService;    
    }
    
    /**
     * Get client's all passengers
     * 
     * @param int $clientId
     */
    public function all()
    {
        $client = auth('client')->user();
        $passengers = $this->passengerService->all($client->id);

        return response()->json([
            'ok' => true,
            'passengers' => $passengers
        ]);
    }

    /**
     * Store a newly created passenger
     * 
     * @param   \App\Http\JsonRequests\StorePassengerRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function store(StorePassengerRequest $request)
    {
        $passenger = $this->passengerService->store($request);

        return response()->json([
            'ok' => true,
            'passenger' => $passenger
        ]);
    }
    
    /**
     * Update an existing passenger
     * 
     * @param   \App\Http\JsonRequests\UpdatePassengerRequest $request
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePassengerRequest $request, $id)
    {
        $this->passengerService->update($request, $id);

        return response()->json([
            'ok' => true
        ]);
    }
}
