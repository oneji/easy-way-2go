<?php

namespace App\Http\Controllers\API;

use App\Http\Services\CarBrandService;
use App\Http\Controllers\Controller;

class CarBrandController extends Controller
{
    private $carBrandService;

    /**
     * CarBrandController constructor
     * 
     * @param \App\Http\Services\CarBrandService $carBrandService
     */
    public function __construct(CarBrandService $carBrandService)
    {
        $this->carBrandService = $carBrandService;
    }

    /**
     * Get all car brands
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $brands = $this->carBrandService->all();

        return response()->json([
            'ok' => true,
            'brands' => $brands
        ]);
    }
}
