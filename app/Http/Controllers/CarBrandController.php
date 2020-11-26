<?php

namespace App\Http\Controllers;

use App\Http\Services\CarBrandService;
use App\Http\Requests\StoreCarBrandRequest;

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
     * Show a listing of car brands
     */
    public function index()
    {
        $carBrands = $this->carBrandService->getPaginated();

        return view('car-brands.index', [
            'carBrands' => $carBrands
        ]);
    }

    /**
     * Get a specific car brand by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        $carBrand = $this->carBrandService->getById($id);

        return response()->json($carBrand);
    }

    /**
     * Store a newly created car brand
     * 
     * @param \App\Http\Requests\StoreCarBrandRequest $request
     */
    public function store(StoreCarBrandRequest $request)
    {
        $this->carBrandService->store($request);

        return redirect()->route('admin.carBrands.index');
    }

    /**
     * Update an existing car brand
     * 
     * @param \App\Http\Requests\StoreCarBrandRequest $request
     * @param int $id
     */
    public function update(StoreCarBrandRequest $request, $id)
    {
        $this->carBrandService->update($request, $id);

        return redirect()->back();
    }
}
