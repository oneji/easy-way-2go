<?php

namespace App\Http\Controllers\API;

use App\Http\JsonRequests\StoreOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\CancelOrderRequest;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;
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
    public function all(Request $request)
    {
        $orders = $this->orderService->getClientOrders($request);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Get order by id
     * 
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getById($id)
    {
        $data = $this->orderService->getById($id);

        return response()->json([
            'success' => true,
            'data' => $data
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
                ], 422);
            }
        } else if($request->order_type === 'passengers') {
            $validator = $this->validatePassengersType($request);
            
            if(!$validator['success']) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator['errors']
                ], 422);
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
            'parking' => 'required',
            'parking_working_hours' => 'nullable',
            'cargos' => 'required',
            'cargos.*.cargo_type_id' => 'required|integer|exists:cargo_types,id',
            'cargos.*.length' => 'required|numeric',
            'cargos.*.width' => 'required|numeric',
            'cargos.*.height' => 'required|numeric',
            'cargos.*.weight' => 'required|numeric',
            'cargos.*.packaging' => 'required|integer',
            // 'cargos.*.photos' => 'required'
        ]);

        if($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        return [ 'success' => true ];
    }
    
    /**
     * Validate passengers order type fields
     * 
     * @param \App\Http\JsonRequests\StoreOrderRequest $request
     */
    private function validatePassengersType(StoreOrderRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'passengers' => 'required',
            'passengers.*.gender' => 'required|integer',
            'passengers.*.first_name' => 'required|string',
            'passengers.*.last_name' => 'required|string',
            'passengers.*.birthday' => 'required|string',
            'passengers.*.nationality' => 'required|integer|exists:countries,id',
            'passengers.*.id_card' => 'required|string',
            'passengers.*.passport_number' => 'required|string',
            'passengers.*.passport_expires_at' => 'required|string',
            'transport_id' => 'required|integer|exists:transports,id',
            'passengers_count' => 'required|integer',
            'packages_count' => 'required|integer'
        ]);

        if($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        return [ 'success' => true ];
    }

    /**
     * Cancel order
     * 
     * @param \App\Http\JsonRequests\CancelOrderRequest $request
     */
    public function cancel(CancelOrderRequest $request)
    {
        $data = $this->orderService->cancel($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
