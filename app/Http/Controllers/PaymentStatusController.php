<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStatusRequest;
use App\Http\Services\PaymentStatusService;

class PaymentStatusController extends Controller
{
    protected $statusService;

    /**
     * PaymentStatusController constructor
     * 
     * @param \App\Http\Services\PaymentStatusService $statusService
     */
    public function __construct(PaymentStatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Show a listing of payment statuses
     */
    public function index()
    {
        $paymentStatuses = $this->statusService->getPaginated();

        return view('payment-statuses.index', [
            'paymentStatuses' => $paymentStatuses
        ]);
    }

    /**
     * Get a specific payment status by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        $paymentStatus = $this->statusService->getById($id);

        return response()->json($paymentStatus);
    }

    /**
     * Store a newly created payment status
     * 
     * @param \App\Http\Requests\PaymentStatusRequest $request
     */
    public function store(PaymentStatusRequest $request)
    {
        $this->statusService->store($request);

        return redirect()->route('admin.paymentStatuses.index');
    }

    /**
     * Update an existing payment status
     * 
     * @param \App\Http\Requests\PaymentStatusRequest $request
     * @param int $id
     */
    public function update(PaymentStatusRequest $request, $id)
    {
        $this->statusService->update($request, $id);

        return redirect()->back();
    }
}
