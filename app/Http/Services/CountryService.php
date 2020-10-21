<?php

namespace App\Http\Services;

use App\Http\Requests\StoreCountryRequest;
use App\Country;

class CountryService
{
    /**
     * Show a listing of countries.
     * 
     * @return collection
     */
    public function all()
    {
        return Country::all();
    }

    /**
     * Get all countries paginated
     */
    public function getPaginated()
    {
        return Country::paginate(10);
    }

    /**
     * Get a specific country item by id.
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return Country::find($id);
        
    }

    /**
     * Store a newly created country.
     * 
     * @param   \App\Http\Requests\StoreCountryRequest $request
     * @return  void
     */
    public function store(StoreCountryRequest $request)
    {
        $lang = new Country();
        
        foreach ($request->translations as $code => $item) {
            $lang->setTranslation('name', $code, $item['name']);
        }

        $lang->code = $request->code;
        $lang->save();

        $request->session()->flash('success', trans('pages.countries.successAddedAlert'));
    }

    /**
     * Update an existing country item.
     * 
     * @param \App\Http\Requests\StoreCountryRequest $request
     * @return void
     */
    public function update(StoreCountryRequest $request, $id)
    {
        $lang = Country::find($id);
        
        foreach ($request->translations as $code => $item) {
            $lang->setTranslation('name', $code, $item['name']);
        }
        $lang->code = $request->code;
        $lang->save();

        $request->session()->flash('success', trans('pages.countries.successEditedAlert'));
    }
}