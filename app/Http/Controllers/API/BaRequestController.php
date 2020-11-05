<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\StoreBaRequest;
use App\Http\Services\BaRequestService;

class BaRequestController extends Controller
{
    private $baService;

    /**
     * BaRequestController constructor
     * 
     * @param \App\Http\Services\BaRequestService $baService
     */
    public function __construct(BaService $baService)
    {
        $this->baService = $this->baService;
    }

    /**
     * Store a newly created bussiness account request
     * 
     * @param \App\Http\JsonRequests\StoreBaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBaRequest $request)
    {
        $this->baService->store($request);

        return response()->json([
            'ok' => true
        ]);
    }
}
