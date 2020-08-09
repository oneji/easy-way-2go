<?php

namespace App\Http\Services;

use App\Http\Requests\StoreCarBrandRequest;
use App\CarBrand;

class CarBrandService
{
    /**
     * Get all car brands
     * 
     * @return collection
     */
    public function all()
    {
        return CarBrand::paginate(10);
    }

    /**
     * Get a specific car brand by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        return CarBrand::find($id);
    }

    /**
     * Store a newly created car brand
     * 
     * @param \App\Http\Requests\StoreCarBrandRequest $request
     */
    public function store(StoreCarBrandRequest $request)
    {
        $carBrand = new CarBrand();
        $carBrand->name = $request->name;
        $carBrand->save();

        $request->session()->flash('success', 'Модель траспорта успешно добавлена.');
    }

    /**
     * Store a newly created car brand
     * 
     * @param \App\Http\Requests\StoreCarBrandRequest $request
     * @param int $id
     */
    public function update(StoreCarBrandRequest $request, $id)
    {
        $carBrand = CarBrand::find($id);
        $carBrand->name = $request->name;
        $carBrand->save();

        $request->session()->flash('success', 'Модель транспорта успешно обновлена.');
    }
}