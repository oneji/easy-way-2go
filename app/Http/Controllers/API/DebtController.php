<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\DebtService;

class DebtController extends Controller
{
    protected $service;

    /**
     * DebtController constructor
     * 
     * @param \App\Http\Services\DebtService $service 
     */
    public function __construct(DebtService $service) {
        $this->service = $service;
    }
    
    /**
     * Get all user's debts
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        $data = $this->service->all($request);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Approve debt payment
     * 
     * @param int $id
     */
    public function approve($id)
    {
        $data = $this->service->approve($id);

        return response()->json($data);
    }
}
