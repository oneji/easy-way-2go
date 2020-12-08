<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Http\Services\PaymentMethodService;

class PaymentMethodController extends Controller
{
    protected $service;

    /**
     * PaymentMethodController constructor
     * 
     * @param \App\Http\Services\PaymentMethodService $service
     */
    public function __construct(PaymentMethodService $service)
    {
        $this->service = $service;
    }

    /**
     * Show a listing of all payment methods
     * 
     * @return \Illumminate\Http\Response
     */
    public function index()
    {
        $data = $this->service->all();

        return view('payment-methods.index', [
            'data' => $data
        ]);
    }

    /**
     * Store a newly created payment methods
     * 
     * @param \App\Http\Requests\PaymentMethodRequest $request
     */
    public function store(PaymentMethodRequest $request)
    {
        $this->service->store($request);

        return redirect()->back();
    }

    /**
     * Update an existing payment methods
     * 
     * @param \App\Http\Requests\PaymentMethodRequest $request
     * @param int $id
     */
    public function update(PaymentMethodRequest $request, $id)
    {
        $this->service->update($request, $id);

        return redirect()->back();
    }

    /**
     * Delete payment methods
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $this->service->delete($id);

        return redirect()->back();
    }

    /**
     * Get by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $item = $this->service->getById($id);

        return response()->json($item);
    }
}
