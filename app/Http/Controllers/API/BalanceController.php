<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\BalanceService;

class BalanceController extends Controller
{
    protected $balanceService;

    /**
     * BalanceController constructor
     * 
     * @param \App\Http\Services\BalanceService $balanceService  
     */
    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * Get all related to the user's balance
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function all(Request $request)
    {
        $data = $this->balanceService->all($request);

        return response()->json($data);
    }
}
