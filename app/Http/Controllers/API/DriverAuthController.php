<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
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
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request)
    {
        $response = $this->driverAuthService->register($request);

        return response()->json($response);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $response = $this->driverAuthService->login(request([ 'email', 'password' ]));

        return response()->json($response);
    }
}
