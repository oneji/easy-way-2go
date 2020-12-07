<?php

namespace App\Http\Services;

use App\HelpSection;
use App\Http\Requests\HelpSectionRequest;
use Illuminate\Support\Facades\Storage;

class HelpSectionService
{
    /**
     * Get all sections
     * 
     * @return collection
     */
    public function all()
    {
        return HelpSection::all();
    }
    
    /**
     * Get all sections paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return HelpSection::paginate(10);
    }

    /**
     * Get by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return HelpSection::find($id);
    }

    /**
     * Store a newly created section
     * 
     * @param \App\Http\Requests\HelpSectionRequest $request
     */
    public function store(HelpSectionRequest $request)
    {
        $section = new HelpSection($request->all());

        if($request->hasFile('icon')) {
            $section->icon = UploadFileService::upload($request->icon, 'help');
        }

        $section->save();
    }

    /**
     * Update an existing section
     * 
     * @param \App\Http\Requests\HelpSectionRequest $request
     * @param int $id
     */
    public function update(HelpSectionRequest $request, $id)
    {
        $section = HelpSection::find($id);
        $section->name = $request->name;

        if($request->hasFile('icon')) {
            Storage::disk('public')->delete($section->icon);
            $section->icon = UploadFileService::upload($request->icon, 'help');
        }

        $section->save();
    }

    /**
     * Delete section
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $section = HelpSection::find($id);
        $section->deleted = 1;
        $section->save();
    }
}