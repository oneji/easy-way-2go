<?php

namespace App\Http\Services;

use App\Http\Requests\StoreCarModelRequest;
use App\CarModel;

class CarModelService
{
    /**
     * Get all car models
     * 
     * @return collection
     */
    public function all()
    {
        return CarModel::paginate(10);
    }

    /**
     * Get a specific car model by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        return CarModel::find($id);
    }

    /**
     * Store a newly created car model
     * 
     * @param \App\Http\Requests\StoreCarModelRequest $request
     */
    public function store(StoreCarModelRequest $request)
    {
        $carModel = new CarModel();
        
        foreach ($request->translations as $code => $value) {
            $carModel->setTranslation('name', $code, $value['name']);
        }

        $carModel->car_brand_id = $request->car_brand_id;
        $carModel->save();

        $request->session()->flash('success', 'Модель траспорта успешно добавлена.');
    }

    /**
     * Store a newly created car model
     * 
     * @param \App\Http\Requests\StoreCarModelRequest $request
     * @param int $id
     */
    public function update(StoreCarModelRequest $request, $id)
    {
        $carModel = CarModel::find($id);
        
        foreach ($request->translations as $code => $value) {
            $carModel->setTranslation('name', $code, $value['name']);
        }

        $carModel->car_brand_id = $request->car_brand_id;
        $carModel->save();

        $request->session()->flash('success', 'Модель транспорта успешно обновлена.');
    }
}