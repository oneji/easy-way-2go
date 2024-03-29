<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\JsonRequests\StoreTransportRequest;
use App\Http\JsonRequests\UpdateTransportRequest;
use App\Http\JsonRequests\BindDriverRequest;
use App\Http\Services\TransportService;
use App\Http\Services\DriverService;
use App\Http\Controllers\Controller;
use Validator;

class TransportController extends Controller
{
    protected $transportService;

    /**
     * TransportController constructor.
     * 
     * @param \App\Http\Services\TransportService $transportService
     * @param \App\Http\Services\DriverService $driverService
     */
    public function __construct(TransportService $transportService)
    {
        $this->transportService = $transportService;
    }

    /**
     * Store a newly created transport
     */
    public function store(StoreTransportRequest $request)
    {
        $data = $this->transportService->store($request->all());

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Update an existing transport
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function update(UpdateTransportRequest $request, $id)
    {
        $data = $this->transportService->update($request->all(), $id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Bind driver to the transport
     * 
     * @param \App\Http\JsonRequests\BindDriverRequest $request
     */
    public function bindDriver(BindDriverRequest $request)
    {
        $this->transportService->bindDriver($request->transport_id, $request->driver_id);

        return response()->json([
            'success' => true
        ]);
    }
}
