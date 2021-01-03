<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\JsonRequests\ChangePasswordRequest;
use App\Http\JsonRequests\UpdateDriverRequest;
use App\Http\Services\DriverService;
use Illuminate\Http\Request;

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

    /**
     * Get a list of trips
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getTrips(Request $request)
    {
        $data = $this->driverService->getTrips($request);
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    
    /**
     * Get a list of finished trips
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getFinishedTrips(Request $request)
    {
        $data = $this->driverService->getFinishedTrips($request);
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get driver's routes
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoutes(Request $request)
    {
        $data = $this->driverService->getRoutes($request);

        return [
            'success' => true,
            'data' => $data
        ];
    }
    
    /**
     * Get driver's archived routes
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArchivedRoutes(Request $request)
    {
        $data = $this->driverService->getArchivedRoutes($request);

        return [
            'success' => true,
            'data' => $data
        ];
    }
}
