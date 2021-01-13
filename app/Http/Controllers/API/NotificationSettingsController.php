<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\NotificationSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationSettingsController extends Controller
{
    protected $service;

    /**
     * NotificationSettingsController constructor
     * 
     * @param \App\Http\Services\NotificationSettingsService $service
     */
    public function __construct(NotificationSettingsService $service)
    {
        $this->service = $service;
    }

    /**
     * Get all notification settings for a user
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        $data = $this->service->all($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Update notification settings
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:my_messages,my_orders,drivers_messages,drivers_orders'
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $this->service->update($request);

        return response()->json([
            'success' => true
        ]);
    }
}
