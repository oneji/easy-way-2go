<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\UserAuthService;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Validator;

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
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [ 'required', 'email' ],
            'password' => [ 'required' ],
            'type' => [ 'required' ]
        ]);

        if($validator->fails()) {
            return response()->json([
                'ok' => false,
                'errors' => $validator->errors()
            ]);
        }

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
