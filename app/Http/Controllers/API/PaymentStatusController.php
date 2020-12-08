<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\PaymentStatusService;

class PaymentStatusController extends Controller
{
    private $statusService;

    /**
     * CarBrandController constructor
     * 
     * @param \App\Http\Services\PaymentStatusService $statusService
     */
    public function __construct(PaymentStatusService $statusService)
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
