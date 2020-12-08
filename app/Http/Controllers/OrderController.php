<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     * Show a listing of orders
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderService->all();
        
        return $orders;

        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show a specific order
     * 
     * @param int $id
     */
    public function show($id)
    {
        $order = $this->orderService->getById($id);

        return view('orders.show', [
            'order' => $order
        ]);
    }
}
