<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BaRequestService;
use App\Http\Requests\ApproveBaRequest;

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

    /**
     * Approve the business account request
     * 
     * @param   \App\Http\ApproveBaRequest $request
     * @param   int $id
     * @return  \Illuminate\Http\Response
     */
    public function approve(ApproveBaRequest $request, $id)
    {
        $this->baService->approve($request, $id);

        return redirect()->back();
    }
    
    /**
     * Decline the business account request
     * 
     * @param   int $id
     * @return  \Illuminate\Http\Response
     */
    public function decline($id)
    {
        $this->baService->decline($id);

        return redirect()->back();
    }
}