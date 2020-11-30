<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\RegisterClientRequest;
use App\Http\Services\ClientAuthService;
use Illuminate\Support\Facades\Validator;

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
     * @param   \App\Http\JsonRequests\RegisterClientRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(RegisterClientRequest $request)
    {
        $response = $this->clientAuthService->register($request);

        return response()->json($response);
    }
}
