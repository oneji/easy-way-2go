<?php

namespace App\Http\Controllers\API;

use App\Http\Services\CountryService;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    private $countryService;

    /**
     * CountryController constructor
     * 
     * @param \App\Http\Services\CountryService $countryService
     */
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * Get all countries
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $countries = $this->countryService->all();

        return response()->json([
            'success' => true,
            'data' => $countries
        ]);
    }
}
