<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DrivingExperienceService;
use App\Http\Requests\StoreDrivingExperienceRequest;
use App\Language;

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
        $langs = Language::all();

        return view('driving-experience.index', [
            'deList' => $deList,
            'langs' => $langs
        ]);
    }

    /**
     * Get a specific driving experience item by id.
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $deItem = $this->deService->getById($id);

        return response()->json($deItem);
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

    /**
     * Update an existing driving experience item.
     * 
     * @param \App\Http\Requests\StoreDrivingExperienceRequest $request
     * @return void
     */
    public function update(StoreDrivingExperienceRequest $request, $id)
    {
        $this->deService->update($request, $id);

        return redirect()->back();
    }
}
