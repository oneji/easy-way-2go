<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\UserAuthService;
use App\Http\JsonRequests\LoginUserRequest;
use App\Http\JsonRequests\VerifyCodeRequest;
use Illuminate\Http\Request;
use Validator;

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

        return response()->json($response, $response['status']);
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

    /**
     * Fetch user from the token
     */
    public function me()
    {
        $data = $this->userAuthService->me();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Refresh token
     */
    public function refreshToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $this->userAuthService->refreshToken($request);

        return response()->json($data, $data['status']);
    }

    /**
     * Sync all user's to the mongo db
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function syncAllToMongo(Request $request)
    {
        $data = $this->userAuthService->syncAllToMongo($request->query('key'));

        return response()->json($data, $data['status']);
    }
}
