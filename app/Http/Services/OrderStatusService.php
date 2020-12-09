<?php

namespace App\Http\Services;

use App\Http\Requests\OrderStatusRequest;
use App\OrderStatus;

class OrderStatusService
{
    /**
     * Get all payment statuses
     * 
     * @return collection
     */
    public function all()
    {
        return OrderStatus::all();
    }
    
    /**
     * Get all payment statuses
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return OrderStatus::paginate(10);
    }

    /**
     * Get a specific payment status by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        return OrderStatus::find($id);
    }

    /**
     * Store a newly created payment status
     * 
     * @param \App\Http\Requests\OrderStatusRequest $request
     */
    public function store(OrderStatusRequest $request)
    {
        $status = new OrderStatus($request->all());
        $status->save();
    }

    /**
     * Store a newly created payment status
     * 
     * @param \App\Http\Requests\OrderStatusRequest $request
     * @param int $id
     */
    public function update(OrderStatusRequest $request, $id)
    {
        $status = OrderStatus::find($id);
        $status->name = $request->name;
        $status->save();
    }
}