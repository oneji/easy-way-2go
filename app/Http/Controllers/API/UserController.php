<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\UserAuthService;
use App\Http\JsonRequests\LoginUserRequest;
use App\Http\JsonRequests\VerifyCodeRequest;

class UserController extends Controller
{
    private $userAuthService;

    /**
     * UserController constructor
     * 
     * @param \App\Http\Services\UserAuthService $userAuthService
     */
    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    /**
     * Autheticate a user with given credentials
     * 
     * @param   \App\Http\JsonRequests\LoginUserRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        $response = $this->userAuthService->login($request);

        return response()->json($response);
    }

    /**
     * Verify user by verification code.
     * 
     * @param   \App\Http\JsonRequests\VerifyCodeRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function verify(VerifyCodeRequest $request)
    {
        $response = $this->userAuthService->verify($request);

        return response()->json($response);
    }
}
