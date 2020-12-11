<?php

namespace App\Http\Services;

use App\Http\Requests\PriceRequest;
use App\Price;

class PriceService
{
    /**
     * Get all price
     * 
     * @return collection 
     */
    public function all()
    {
        return Price::all();
    }

    /**
     * Get all prices paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return Price::paginate(10);
    }

    /**
     * Get a specific price by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        return Price::find($id);
    }
    
    /**
     * Store a newly created price
     * 
     * @param \App\Http\Requests\PriceRequest $request 
     */
    public function store(PriceRequest $request)
    {
        $price = new Price($request->all());
        $price->save();
    }

    /**
     * Update an existing price
     * 
     * @param \App\Http\Requests\PriceRequest $request 
     * @param int $id
     */
    public function update(PriceRequest $request, $id)
    {
        $price = Price::find($id);
        $price->name = $request->name;
        $price->code = $request->code;
        $price->unit = $request->unit;
        $price->price = $request->price;
        $price->save();
    }
}