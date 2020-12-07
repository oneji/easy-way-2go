<?php

namespace App\Http\Controllers;

use App\HelpSection;
use App\Http\Requests\HelpItemRequest;
use App\Http\Services\HelpItemService;

class HelpItemController extends Controller
{
    protected $itemService;

    /**
     * FaqController constructor
     * 
     * @param \App\Http\Services\HelpItemService $itemService
     */
    public function __construct(HelpItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * Show create help form
     */
    public function create()
    {
        $sections = HelpSection::all();

        return view('help.create', [
            'sections' => $sections
        ]);
    }

    /**
     * Store a newly created help
     * 
     * @param \App\Http\Requests\HelpItemRequest $request
     */
    public function store(HelpItemRequest $request)
    {
        $this->itemService->store($request);

        return redirect()->back();
    }

    /**
     * Show an edit form
     * 
     * @param int $id
     */
    public function edit($id)
    {
        $item = $this->itemService->getById($id);
        $sections = HelpSection::all();

        return view('help.edit', [
            'item' => $item,
            'sections' => $sections
        ]);
    }

    /**
     * Update an existing help
     * 
     * @param \App\Http\Requests\HelpItemRequest $request
     * @param int $id
     */
    public function update(HelpItemRequest $request, $id)
    {
        $this->itemService->update($request, $id);

        return redirect()->back();
    }

    /**
     * Delete help
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $this->itemService->delete($id);

        return redirect()->back();
    }
}
