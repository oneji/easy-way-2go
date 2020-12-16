<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\ChangePasswordRequest;
use App\Http\Services\DriverService;

class DriverController extends Controller
{
    private $driverService;

    /**
     * DriverController constructor
     * 
     * @param \App\Http\Services\DriverService $driverService
     */
    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    /**
     * Change password
     * 
     * @param \App\Http\JsonRequests\ChangePasswordRequest $request
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $response = $this->driverService->changePassword($request);

        return response()->json($response, $response['status']);
    }
}
