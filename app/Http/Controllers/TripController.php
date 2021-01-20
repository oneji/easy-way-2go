<?php

namespace App\Http\Controllers;

use App\Http\Services\TripService;
use App\PaymentMethod;
use Illuminate\Http\Request;

class TripController extends Controller
{
    private $tripService;

    /**
     * TripController constructor
     * 
     * @param \App\Http\Service\TripService $tripService
     */
    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }

    /**
     * Show a listing of all trips
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trips = $this->tripService->all($request);

        return view('trips.index', [
            'trips' => $trips
        ]);
    }

    /**
     * Show a specific trip
     * 
     * @param   \Illuminate\Http\Request $request
     * @param   int $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = $this->tripService->getById($request, $id);
        $paymentMethods = PaymentMethod::all();

        // return $data;

        return view('trips.show', $data)->with([ 'paymentMethods' => $paymentMethods ]);
    }
}
