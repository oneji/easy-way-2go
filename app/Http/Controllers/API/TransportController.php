<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\JsonRequests\StoreTransportRequest;
use App\Http\Services\TransportService;
use App\Http\Services\DriverService;
use App\Http\Controllers\Controller;
use Validator;

class TransportController extends Controller
{
    private $transportService;
    private $driverService;

    /**
     * TransportController constructor.
     * 
     * @param \App\Http\Services\TransportService $transportService
     * @param \App\Http\Services\DriverService $driverService
     */
    public function __construct(TransportService $transportService, DriverService $driverService)
    {
        $this->transportService = $transportService;
        $this->driverService = $driverService;
    }

    /**
     * Store a newly created transport
     */
    public function store(StoreTransportRequest $request)
    {
        $this->transportService->store($request);

        return response()->json([
            'ok' => true
        ]);
    }

    /**
     * Update an existing transport
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function update(Request $request)
    {
        $this->transportService->update($request);

        return response()->json([
            'ok' => true
        ]);
    }

    /**
     * Bind driver to the transport
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function bindDriver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transport_id' => 'required|integer|exists:transports,id',
            'driver_id' => 'required|integer|exists:users,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'ok' => false,
                'errors' => $validator->errors()
            ]);
        }

        $this->transportService->bindDriver($request);
    }
}
