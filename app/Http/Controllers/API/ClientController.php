<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\JsonRequests\ChangePasswordRequest;
use App\Http\JsonRequests\UpdateClientRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\ClientService;

class ClientController extends Controller
{
    private $clientService;

    /**
     * ClientController constructor
     * 
     * @param \App\Http\Services\ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Update client's profile
     * 
     * @param   \App\Http\JsonRequests\UpdateClientRequest $request
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function update(UpdateClientRequest $request, $id)
    {
        $this->clientService->updateProfile($request, $id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Change password
     * 
     * @param \App\Http\JsonRequests\ChangePasswordRequest $request
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $this->clientService->changePassword($request);

        return response()->json([
            'success' => true
        ]);
    }
}
