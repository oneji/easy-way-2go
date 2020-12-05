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
    public function all(Request $request)
    {
        $client = auth('client')->user();
        $passengers = $this->passengerService->all($client->id, $request->query('name'));

        return response()->json([
            'success' => true,
            'data' => $passengers
        ]);
    }

    /**
     * Get by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $data = $this->passengerService->getById($id);

        return response()->json([
            'success' => true,
            'data' => $data
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
            'success' => true,
            'data' => $passenger
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
        $data = $this->passengerService->update($request, $id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Delete passenger
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $this->passengerService->delete($id);

        return response()->json([
            'success' => true
        ]);
    }
}
