<?php

namespace App\Http\Services;

use App\Http\Requests\PaymentMethodRequest;
use App\PaymentMethod;
use Illuminate\Support\Facades\Storage;

class PaymentMethodService
{
    /**
     * Get all methods
     * 
     * @return collection
     */
    public function all()
    {
        return PaymentMethod::all();
    }
    
    /**
     * Get all methods paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return PaymentMethod::paginate(10);
    }

    /**
     * Get by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return PaymentMethod::find($id);
    }

    /**
     * Store a newly created method
     * 
     * @param \App\Http\Requests\PaymentMethodRequest $request
     */
    public function store(PaymentMethodRequest $request)
    {
        $method = new PaymentMethod($request->all());

        if($request->hasFile('icon')) {
            $method->icon = UploadFileService::upload($request->icon, 'payment-methods');
        }

        $method->save();
    }

    /**
     * Update an existing method
     * 
     * @param \App\Http\Requests\PaymentMethodRequest $request
     * @param int $id
     */
    public function update(PaymentMethodRequest $request, $id)
    {
        $method = PaymentMethod::find($id);
        $method->name = $request->name;
        $method->code = $request->code;

        if($request->hasFile('icon')) {
            Storage::disk('public')->delete($method->icon);
            $method->icon = UploadFileService::upload($request->icon, 'payment_methods');
        }

        $method->save();
    }

    /**
     * Delete method
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $method = PaymentMethod::find($id);
        $method->deleted = 1;
        $method->save();
    }
}