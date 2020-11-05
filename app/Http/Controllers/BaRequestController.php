<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BaRequestService;

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
     * Show a listing of bussiness account requests
     * 
     * @param \Illuminate\Http\Response
     */
    public function index()
    {
        $baRequests = $this->baService->getPaginated();

        return view('bas.index', [
            'baRequests' => $baRequests
        ]);
    }
}
