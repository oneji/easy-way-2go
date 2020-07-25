<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DrivingExperienceService;
use App\Http\Requests\StoreDrivingExperienceRequest;

class DrivingExperienceController extends Controller
{
    private $deService;

    /**
     * DrivingExperienceController constructor
     * 
     * @param \App\Http\Services\DrivingExperienceService $deService
     */
    public function __construct(DrivingExperienceService $deService)
    {
        $this->deService = $deService;
    }

    /**
     * Show a listing of resources
     * 
     * @return void
     */
    public function index()
    {
        $deList = $this->deService->all();

        return view('driving-experience.index', [
            'deList' => $deList
        ]);
    }

    /**
     * Store a newly created item
     * 
     * @param   \App\Htt\Requests\StoreDrivingExperienceRequest $request
     * @return  void
     */
    public function store(StoreDrivingExperienceRequest $request)
    {
        $this->deService->store($request);

        $request->session()->flash('success', 'Водительский опыт успешно добавлен.');

        return redirect()->back();
    }
}
