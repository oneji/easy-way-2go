<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\ChangeBrigadirPasswordRequest;
use App\Http\JsonRequests\DetachDriverFromOrderRequest;
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
    public function getDriversGroupedByTransport(Request $request)
    {
        $data = $this->brigadirService->getDriversGroupedByTransport($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get a list of orders
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getOrders(Request $request)
    {
        $data = $this->brigadirService->getOrders($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get a speificic order by id
     * 
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getOrderById(Request $request, $id)
    {
        $data = $this->brigadirService->getOrderById($request, $id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get all available transport
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getTransport(Request $request)
    {
        $data = $this->brigadirService->getTransport($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Block driver access
     * 
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function blockDriver($id)
    {
        $this->brigadirService->blockDriver($id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Detach driver from order
     * 
     * @param   \App\Http\JsonRequests\DetachDriverFromOrderRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function detachDriverFromOrder(DetachDriverFromOrderRequest $request)
    {
        $this->brigadirService->detachDriverFromOrder($request->driver_id, $request->order_id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Get drivers
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
