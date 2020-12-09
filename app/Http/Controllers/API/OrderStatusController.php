<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderStatusService;

class OrderStatusController extends Controller
{
    private $statusService;

    /**
     * CarBrandController constructor
     * 
     * @param \App\Http\Services\OrderStatusService $statusService
     */
    public function __construct(OrderStatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Get all payment statuses
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $data = $this->statusService->all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
