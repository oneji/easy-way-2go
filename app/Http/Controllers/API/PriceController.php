<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\PriceService;

class PriceController extends Controller
{
    private $priceService;

    /**
     * PriceController constructor
     * 
     * @param \App\Http\Services\PriceService $priceService
     */
    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * Get all payment statuses
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $data = $this->priceService->all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
