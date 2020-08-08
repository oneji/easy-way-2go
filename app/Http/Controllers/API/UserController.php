<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\UserAuthService;
use App\Http\Requests\LoginUserRequest;

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
     * @param \App\Http\Requests\LoginUserRequest $request
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
     * @param   int $verificationCode
     * @return  \Illuminate\Http\JsonResponse
     */
    public function verify($verificationCode)
    {
        $response = $this->userAuthService->verify($verificationCode);

        return response()->json($response);
    }
}
