<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\JsonRequests\RegisterBrigadirRequest;
use App\Http\Services\BrigadirAuthService;

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
     * @param   \App\Http\JsonRequests\RegisterBrigadirRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(RegisterBrigadirRequest $request)
    {
        $response = $this->brigadirAuthService->register($request);

        return response()->json($response);
    }
}
