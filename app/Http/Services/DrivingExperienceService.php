<?php

namespace App\Http\Services;
use App\DrivingExperience;
use App\Http\Requests\StoreDrivingExperienceRequest;

class DrivingExperienceService
{
    /**
     * Show a listing of item
     * 
     * @return collection
     */
    public function all()
    {
        return DrivingExperience::all();
    }

    /**
     * Store a newly created item
     * 
     * @param   \App\Htt\Requests\StoreDrivingExperienceRequest $request
     * @return  void
     */
    public function store(StoreDrivingExperienceRequest $request)
    {
        $deItem = new DrivingExperience();
        $deItem->name = $request->name;
        $deItem->save();
    }
}