<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Http\Services\OrderStatusService;

class OrderStatusController extends Controller
{
    protected $statusService;

    /**
     * OrderStatusController constructor
     * 
     * @param \App\Http\Services\OrderStatusService $statusService
     */
    public function __construct(OrderStatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Show a listing of order statuses
     */
    public function index()
    {
        $orderStatuses = $this->statusService->getPaginated();

        return view('order-statuses.index', [
            'orderStatuses' => $orderStatuses
        ]);
    }

    /**
     * Get a specific car brand by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        $orderStatus = $this->statusService->getById($id);

        return response()->json($orderStatus);
    }

    /**
     * Store a newly created car brand
     * 
     * @param \App\Http\Requests\OrderStatusRequest $request
     */
    public function store(OrderStatusRequest $request)
    {
        $this->statusService->store($request);

        return redirect()->route('admin.orderStatuses.index');
    }

    /**
     * Update an existing car brand
     * 
     * @param \App\Http\Requests\OrderStatusRequest $request
     * @param int $id
     */
    public function update(OrderStatusRequest $request, $id)
    {
        $this->statusService->update($request, $id);

        return redirect()->back();
    }
}
