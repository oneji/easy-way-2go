<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\ChangeBrigadirPasswordRequest;
use App\Http\JsonRequests\InviteDriverRequest;
use App\Http\JsonRequests\UpdateBrigadirCompanyRequest;
use App\Http\JsonRequests\UpdateBrigadirRequest;
use App\Http\Services\BrigadirService;

class BrigadirController extends Controller
{
    protected $brigadirService;

    /**
     * BrigadirController constructor
     * 
     * @param \App\Http\Services\BrigadirService $brigadirService
     */
    public function __construct(BrigadirService $brigadirService) {
        $this->brigadirService = $brigadirService;
    }

    /**
     * Update brigadir profile
     * 
     * @param   \App\Http\JsonRequests\UpdateBrigadirRequest $request
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateBrigadirRequest $request, $id)
    {
        $data = $this->brigadirService->updateProfile($request, $id);

        if(!$data) abort(404);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    
    /**
     * Update brigadir profile
     * 
     * @param   \App\Http\JsonRequests\UpdateBrigadirCompanyRequest $request
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function updateCompany(UpdateBrigadirCompanyRequest $request, $id)
    {
        $data = $this->brigadirService->updateCompany($request, $id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Update brigadir's password
     * 
     * @param   \App\Http\JsonRequests\ChangeBrigadirPasswordRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangeBrigadirPasswordRequest $request)
    {
        $response = $this->brigadirService->changePassword($request);

        return response()->json($response, $response['status']);
    }

    /**
     * Invite driver
     * 
     * @param   \App\Http\JsonRequests\InviteDriverRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function inviteDriver(InviteDriverRequest $request)
    {
        $this->brigadirService->inviteDriver($request);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Get all drivers
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getDrivers(Request $request)
    {
        $data = $this->brigadirService->getDrivers($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
