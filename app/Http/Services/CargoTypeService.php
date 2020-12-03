<?php

namespace App\Http\Services;

use App\CargoType;
use App\Http\Requests\CargoTypeRequest;

class CargoTypeService
{
    /**
     * Get all cargo types
     * 
     * @return collection
     */
    public function all()
    {
        return CargoType::all();
    }

    /**
     * Get all cargo type paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return CargoType::paginate(10);
    }

    /**
     * Get a specific cargo type
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return CargoType::find($id);
    }

    /**
     * Store a newly created cargo type
     * 
     * @param \App\Http\Requests\CargoTypeRequest $request
     */
    public function store(CargoTypeRequest $request)
    {
        $cargoType = new CargoType($request->all());
        $cargoType->save();
    }

    /**
     * Update cargo type
     * 
     * @param \App\Http\Requests\CargoTypeRequest $request
     * @param int $id
     */
    public function update(CargoTypeRequest $request, $id)
    {
        $cargoType = CargoType::find($id);
        $cargoType->name = $request->name;
        $cargoType->save();
    }
}