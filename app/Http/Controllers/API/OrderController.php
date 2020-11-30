<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\JsonRequests\StoreOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;

class OrderController extends Controller
{
    private $orderService;

    /**
     * OrderController constructor
     * 
     * @param \App\Http\Services\OrderService $orderService 
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Get all orders
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $orders = $this->orderService->getClientOrders();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created order
     * 
     * @param  \App\Http\JsonRequests\StoreOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderRequest $request)
    {
        $this->orderService->store($request);

        return response()->json([
            'success' => true
        ]);
    }
}
