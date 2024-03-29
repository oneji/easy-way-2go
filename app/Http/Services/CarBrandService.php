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
        return CarBrand::all();
    }
    
    /**
     * Get all car brands
     * 
     * @return collection
     */
    public function getPaginated()
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
        
        foreach ($request->translations as $code => $value) {
            $carBrand->setTranslation('name', $code, $value['name']);
        }
        
        $carBrand->save();

        $request->session()->flash('success', 'Марка траспорта успешно добавлена.');
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
        
        foreach ($request->translations as $code => $value) {
            $carBrand->setTranslation('name', $code, $value['name']);
        }
        
        $carBrand->save();

        $request->session()->flash('success', 'Марка транспорта успешно обновлена.');
    }
}