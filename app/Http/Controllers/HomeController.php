<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DriverService;
use App\Http\Services\ClientService;
use App\Http\Services\BrigadirService;

class HomeController extends Controller
{
    private $driverService;
    private $clientService;
    private $brigadirService;
    /**
     * Create a new controller instance.
     *
     * @param \App\Http\Services\DriverService $driverService
     * @param \App\Http\Services\ClientService $clientService
     * @param \App\Http\Services\BrigadirService $brigadirService
     * @return void
     */
    public function __construct(DriverService $driverService, ClientService $clientService, BrigadirService $brigadirService)
    {
        $this->middleware('auth');

        $this->driverService = $driverService;
        $this->clientService = $clientService;
        $this->brigadirService = $brigadirService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'driversCount' => $this->driverService->count(),
            'clientsCount' => $this->clientService->count(),
            'brigadirsCount' => $this->brigadirService->count()
        ]);
    }
}
