<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\BrigadirAuthService;
use Illuminate\Support\Facades\Validator;

class BrigadirAuthController extends Controller
{
    private $brigadirAuthService;

    /**
     * AuthController construct function
     * 
     * @param \App\Http\Services\BrigadirAuthService $brigadirAuthService
     */
    public function __construct(BrigadirAuthService $brigadirAuthService)
    {
        $this->brigadirAuthService = $brigadirAuthService;
    }

    /**
     * Store a newly created user in the db.
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable']
        ]);

        if($validator->fails()) {
            return response()->json([
                'ok' => false,
                'errors' => $validator->errors()
            ], 401);
        }

        $response = $this->brigadirAuthService->register($request);

        return response()->json($response);
    }
}
