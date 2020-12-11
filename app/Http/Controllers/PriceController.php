<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use App\Http\Services\PriceService;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    protected $priceService;

    /**
     * PriceController constructor
     * 
     * @param \App\Http\Services\PriceService $priceService
     */
    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * Show a listing of prices
     */
    public function index()
    {
        $prices = $this->priceService->getPaginated();

        return view('prices.index', [
            'prices' => $prices
        ]);
    }

    /**
     * Get a specific price by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        $paymentStatus = $this->priceService->getById($id);

        return response()->json($paymentStatus);
    }

    /**
     * Store a newly created price
     * 
     * @param \App\Http\Requests\PriceRequest $request
     */
    public function store(PriceRequest $request)
    {
        $this->priceService->store($request);

        return redirect()->route('admin.prices.index');
    }

    /**
     * Update an existing price
     * 
     * @param \App\Http\Requests\PriceRequest $request
     * @param int $id
     */
    public function update(PriceRequest $request, $id)
    {
        $this->priceService->update($request, $id);

        return redirect()->back();
    }
}
