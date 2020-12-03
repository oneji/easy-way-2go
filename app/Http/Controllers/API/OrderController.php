<?php

namespace App\Http\Controllers\API;

use App\Http\JsonRequests\StoreOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use Illuminate\Support\Facades\Validator;

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
        if($request->order_type === 'moving') {
            $validator = $this->validateMovingType($request);
            
            if(!$validator['success']) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator['errors']
                ]);
            }
        }

        $data = $this->orderService->store($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Validate moving order type fields
     * 
     * @param \App\Http\JsonRequests\StoreOrderRequest $request
     */
    private function validateMovingType(StoreOrderRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'from_floor' => 'required|integer',
            'to_floor' => 'required|integer',
            'time' => 'required',
            'movers_count' => 'required|integer',
            'parking' => 'required|integer',
            'parking_working_hours' => 'nullable',
            'cargos' => 'required',
            'cargos.*.cargo_type_id' => 'required|integer|exists:cargo_types,id',
            'cargos.*.length' => 'required|numeric',
            'cargos.*.width' => 'required|numeric',
            'cargos.*.height' => 'required|numeric',
            'cargos.*.weight' => 'required|numeric',
            'cargos.*.packaging' => 'required|integer',
            'cargos.*.photos' => 'required'
        ]);

        if($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        return [ 'success' => true ];
    }
}
