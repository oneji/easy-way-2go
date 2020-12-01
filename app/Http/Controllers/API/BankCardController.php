<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\JsonRequests\StoreBankCardRequest;
use App\Http\Services\BankCardService;

class BankCardController extends Controller
{
    protected $cardService;

    /**
     * BankCardController constructor
     * 
     * @param \App\Http\Services\BankCardService
     */
    public function __construct(BankCardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Get all user's bank cards
     * 
     * @return collection
     */
    public function all()
    {
        $data = $this->cardService->all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created bank card
     * 
     * @param \App\Http\JsonRequests\StoreBankCardRequest
     */
    public function store(StoreBankCardRequest $request)
    {
        $this->cardService->store($request);

        return response()->json([
            'success' => true
        ]);
    }
}
