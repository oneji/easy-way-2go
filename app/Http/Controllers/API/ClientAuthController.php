<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Services\ClientAuthService;

class ClientAuthController extends Controller
{
    private $clientAuthService;

    /**
     * AuthController construct function
     * 
     * @param \App\Http\Services\ClientAuthService $clientAuthService
     */
    public function __construct(ClientAuthService $clientAuthService)
    {
        $this->clientAuthService = $clientAuthService;
    }

    /**
     * Store a newly created user in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request)
    {
        $response = $this->clientAuthService->register($request);

        return response()->json($response);
    }

    /**
     * Verify user by verification code.
     * 
     * @param   int $verificationCode
     * @return  \Illuminate\Http\JsonResponse
     */
    public function verify($verificationCode)
    {
        $response = $this->clientAuthService->verify($verificationCode);

        return response()->json($response);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $response = $this->clientAuthService->login(request([ 'email', 'password' ]));

        return response()->json($response);
    }
}
