<?php

namespace App\Http\Controllers\API;

use App\Http\Services\DrivingExperienceService;
use App\Http\Controllers\Controller;

class DrivingExperienceController extends Controller
{
    private $deService;

    /**
     * DrivingExperienceController constructor
     * 
     * @param \App\Http\Services\DrivingExperienceService $deService
     */
    public function __construct(DrivingExperienceService $deService)
    {
        $this->deService = $deService;
    }

    /**
     * Get all driving experiences
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $data = $this->deService->all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
