<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\ChangeBrigadirPasswordRequest;
use App\Http\JsonRequests\DetachDriverFromOrderRequest;
use App\Http\JsonRequests\AttachDriverToOrderRequest;
use App\Http\JsonRequests\InviteDriverRequest;
use App\Http\JsonRequests\UpdateBrigadirCompanyRequest;
use App\Http\JsonRequests\UpdateBrigadirRequest;
use App\Http\Services\BrigadirService;
use Illuminate\Support\Facades\Validator;

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
     * Get a list of trips
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getTrips(Request $request)
    {
        $data = $this->brigadirService->getTrips($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get a speificic trip by id
     * 
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getTripById(Request $request, $id)
    {
        $data = $this->brigadirService->getTripById($request, $id);

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

    /**
     * Attach driver from order
     * 
     * @param   \App\Http\JsonRequests\AttachDriverToOrderRequest $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function attachDriverToOrder(AttachDriverToOrderRequest $request)
    {
        $this->brigadirService->attachDriverToOrder($request->driver_id, $request->order_id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Get driver by id
     * 
     * @param int $id
     */
    public function getDriverById($id)
    {
        $data = $this->brigadirService->getDriverById($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get driver's transport
     * 
     * @param int $id
     */
    public function getDriversTransport($id)
    {
        $data = $this->brigadirService->getDriversTransport($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Change drivers password
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function changeDriversPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed'
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $this->brigadirService->changeDriversPassword($request, $id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Get routes
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getRoutes(Request $request)
    {
        $data = $this->brigadirService->getRoutes($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    
    /**
     * Get archived routes
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getArchivedRoutes(Request $request)
    {
        $data = $this->brigadirService->getArchivedRoutes($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
