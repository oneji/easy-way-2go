<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\PaymentMethodService;

class PaymentMethodController extends Controller
{
    protected $service;

    /**
     * PaymentMethodController constructor
     * 
     * @param \App\Http\Services\PaymentMethodService $service
     */
    public function __construct(PaymentMethodService $service)
    {
        $this->service = $service;
    }

    /**
     * Get all payment methods
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $data = $this->service->all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
