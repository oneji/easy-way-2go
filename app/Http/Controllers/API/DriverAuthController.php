<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\JsonRequests\RegisterDriverRequest;
use App\Http\Services\DriverAuthService;

class DriverAuthController extends Controller
{
    private $driverAuthService;

    /**
     * AuthController construct function
     * 
     * @param \App\Http\Services\DriverAuthService $driverAuthService
     */
    public function __construct(DriverAuthService $driverAuthService)
    {
        $this->driverAuthService = $driverAuthService;
    }

    /**
     * Store a newly created user in the db.
     * 
     * @param   \App\Http\JsonRequests\RegisterDriverRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(RegisterDriverRequest $request)
    {
        $response = $this->driverAuthService->register($request);

        return response()->json($response);
    }
}
