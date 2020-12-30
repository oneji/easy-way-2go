<?php

namespace App\Http\Services;

use App\Http\Requests\PaymentStatusRequest;
use App\PaymentStatus;

class PaymentStatusService
{
    /**
     * Get all payment statuses
     * 
     * @return collection
     */
    public function all()
    {
        return PaymentStatus::all();
    }
    
    /**
     * Get all payment statuses paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return PaymentStatus::paginate(10);
    }

    /**
     * Get a specific payment status by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        return PaymentStatus::find($id);
    }

    /**
     * Store a newly created payment status
     * 
     * @param \App\Http\Requests\PaymentStatusRequest $request
     */
    public function store(PaymentStatusRequest $request)
    {
        $status = new PaymentStatus($request->all());
        $status->save();
    }

    /**
     * Store a newly created payment status
     * 
     * @param \App\Http\Requests\PaymentStatusRequest $request
     * @param int $id
     */
    public function update(PaymentStatusRequest $request, $id)
    {
        $status = PaymentStatus::find($id);
        $status->name = $request->name;
        $status->code = $request->code;
        $status->save();
    }
}