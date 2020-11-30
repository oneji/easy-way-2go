<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\JsonRequests\StoreBaRequest;
use App\Http\Services\BaRequestService;
use Validator;

class BaRequestController extends Controller
{
    private $baService;

    /**
     * BaRequestController constructor
     * 
     * @param \App\Http\Services\BaRequestService $baService
     */
    public function __construct(BaRequestService $baService)
    {
        $this->baService = $baService;
    }

    /**
     * Get a specific bussiness account request by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $baRequest = $this->baService->getById($id);

        return response()->json([
            'success' => true,
            'data' => $baRequest
        ]);
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
            'success' => true
        ]);
    }
}
