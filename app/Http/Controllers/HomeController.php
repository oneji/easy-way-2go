<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\StatsService;

class HomeController extends Controller
{
    private $statsService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Http\Services\StatsService $statsService
     * @return void
     */
    public function __construct(StatsService $statsService)
    {
        $this->middleware('auth');

        $this->statsService = $statsService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', $this->statsService->all());
    }
}
