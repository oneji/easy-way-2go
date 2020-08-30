<?php

namespace App\Http\Services;
use App\DrivingExperience;
use App\Http\Requests\StoreDrivingExperienceRequest;

class DrivingExperienceService
{
    /**
     * Show a listing of driving experience.
     * 
     * @return collection
     */
    public function all()
    {
        return DrivingExperience::paginate(10);
    }

    /**
     * Get a specific driving experience item by id.
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return DrivingExperience::find($id);
        
    }

    /**
     * Store a newly created item.
     * 
     * @param   \App\Http\Requests\StoreDrivingExperienceRequest $request
     * @return  void
     */
    public function store(StoreDrivingExperienceRequest $request)
    {
        $deItem = new DrivingExperience();
        $deItem->name = $request->name;
        $deItem->save();
    }

    /**
     * Update an existing driving experience item.
     * 
     * @param \App\Http\Requests\StoreDrivingExperienceRequest $request
     * @return void
     */
    public function update(StoreDrivingExperienceRequest $request, $id)
    {
        $deItem = DrivingExperience::find($id);
        $deItem->name = $request->name;
        $deItem->save();
    }
}