<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\JsonRequests\ChangePasswordRequest;
use App\Http\JsonRequests\UpdateDriverRequest;
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
     * @param   \App\Http\JsonRequests\ChangePasswordRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $response = $this->driverService->changePassword($request);

        return response()->json($response, $response['status']);
    }

    /**
     * Update driver's profile
     * 
     * @param   \App\Http\JsonRequests\UpdateDriverRequest $request
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDriverRequest $request, $id)
    {
        $data = $this->driverService->updateProfile($request, $id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
