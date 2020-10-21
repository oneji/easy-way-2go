<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CountryService;
use App\Http\Requests\StoreCountryRequest;

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
     * Show a listing of resources
     * 
     * @return void
     */
    public function index()
    {
        $countries = $this->countryService->getPaginated();

        return view('countries.index', [
            'countries' => $countries
        ]);
    }

    /**
     * Get a specific driving experience item by id.
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $country = $this->countryService->getById($id);

        return response()->json($country);
    }

    /**
     * Store a newly created item
     * 
     * @param   \App\Htt\Requests\StoreCountryRequest $request
     * @return  void
     */
    public function store(StoreCountryRequest $request)
    {
        $this->countryService->store($request);

        return redirect()->back();
    }

    /**
     * Update an existing driving experience item.
     * 
     * @param \App\Http\Requests\StoreCountryRequest $request
     * @return void
     */
    public function update(StoreCountryRequest $request, $id)
    {
        $this->countryService->update($request, $id);

        return redirect()->back();
    }
}
