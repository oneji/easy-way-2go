<?php

namespace App\Http\Controllers\API;

use App\Http\Services\CarModelService;
use App\Http\Controllers\Controller;

class CarModelController extends Controller
{
    private $carModelService;

    /**
     * CarModelController constructor
     * 
     * @param \App\Http\Services\CarModelService $carModelService
     */
    public function __construct(CarModelService $carModelService)
    {
        $this->carModelService = $carModelService;
    }

    /**
     * Get all car models
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $models = $this->carModelService->all();

        return response()->json([
            'ok' => true,
            'models' => $models
        ]);
    }

    /**
     * Get car models by brand
     * 
     * @param int $brandId
     */
    public function getByBrandId($brandId)
    {
        $models = $this->carModelService->getByBrandId($brandId);

        return response()->json([
            'ok' => true,
            'models' => $models
        ]);
    }
}
