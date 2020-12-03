<?php

namespace App\Http\Controllers;

use App\Http\Requests\CargoTypeRequest;
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
     * Show a listing of cargo types
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargoTypes = $this->cargoTypeService->getPaginated();

        return view('cargo-types.index', [
            'cargoTypes' => $cargoTypes
        ]);
    }

    /**
     * Get a specific cargo type by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $type = $this->cargoTypeService->getById($id);

        return response()->json($type);
    }

    /**
     * Store a newly created cargo type
     * 
     * @param   \App\Http\Requests\CargoTypeRequest $request
     * @return  \Illuminate\Http\Response
     */
    public function store(CargoTypeRequest $request)
    {
        $this->cargoTypeService->store($request);

        return redirect()->back();
    }
    
    /**
     * Update a cargo type
     * 
     * @param   \App\Http\Requests\CargoTypeRequest $request
     * @param   int $id 
     * @return  \Illuminate\Http\Response
     */
    public function update(CargoTypeRequest $request, $id)
    {
        $this->cargoTypeService->update($request, $id);

        return redirect()->back();
    }
}
