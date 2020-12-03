<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\CargoTypeService;

class CargoTypeController extends Controller
{
    protected $cargoTypeService;

    /**
     * CargoTypeController constructor
     * 
     * @param \App\Http\Services\CargoTypeService $cargoTypeService
     */
    public function __construct(CargoTypeService $cargoTypeService) {
        $this->cargoTypeService = $cargoTypeService;
    }
    
    /**
     * Get all cargo types
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $data = $this->cargoTypeService->all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
