<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CarModelService;
use App\Http\Requests\StoreCarModelRequest;
use App\CarBrand;

class CarModelController extends Controller
{
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
     * Show a listing of car models
     */
    public function index()
    {
        $carModels = $this->carModelService->getPaginated();
        $carBrands = CarBrand::all();

        return view('car-models.index', [
            'carModels' => $carModels,
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
        $carModel = $this->carModelService->getById($id);

        return response()->json($carModel);
    }

    /**
     * Store a newly created car brand
     * 
     * @param \App\Http\Requests\StoreCarModelRequest $request
     */
    public function store(StoreCarModelRequest $request)
    {
        $this->carModelService->store($request);

        return redirect()->route('admin.carModels.index');
    }

    /**
     * Update an existing car brand
     * 
     * @param \App\Http\Requests\StoreCarModelRequest $request
     * @param int $id
     */
    public function update(StoreCarModelRequest $request, $id)
    {
        $this->carModelService->update($request, $id);

        return redirect()->back();
    }
}
