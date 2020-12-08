<?php

namespace App\Http\Controllers;

use App\Http\Requests\HelpSectionRequest;
use App\Http\Services\HelpSectionService;

class HelpSectionController extends Controller
{
    protected $sectionService;

    /**
     * FaqController constructor
     * 
     * @param \App\Http\Services\HelpSectionService $sectionService
     */
    public function __construct(HelpSectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    /**
     * Show a listing of all help
     * 
     * @return \Illumminate\Http\Response
     */
    public function index()
    {
        $data = $this->sectionService->getPaginated();

        return view('help.index', [
            'data' => $data
        ]);
    }

    /**
     * Show create help form
     */
    public function create()
    {
        return view('help.create');
    }

    /**
     * Store a newly created help
     * 
     * @param \App\Http\Requests\HelpSectionRequest $request
     */
    public function store(HelpSectionRequest $request)
    {
        $this->sectionService->store($request);

        return redirect()->back();
    }

    /**
     * Show an edit form
     * 
     * @param int $id
     */
    public function edit($id)
    {
        $item = $this->sectionService->getById($id);

        return view('help.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update an existing help
     * 
     * @param \App\Http\Requests\HelpSectionRequest $request
     * @param int $id
     */
    public function update(HelpSectionRequest $request, $id)
    {
        $this->sectionService->update($request, $id);

        return redirect()->back();
    }

    /**
     * Delete help
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $this->sectionService->delete($id);

        return redirect()->back();
    }

    /**
     * Get by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $item = $this->sectionService->getById($id);

        return response()->json($item);
    }
}
