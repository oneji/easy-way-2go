<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use App\Http\Traits\UploadDocsTrait;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use App\DriverData;
use Carbon\Carbon;

class DriverService
{
    use UploadImageTrait, UploadDocsTrait;

    /**
     * Get all the drivers
     * 
     * @return collection
     */
    public function all()
    {
        return User::with([
            'driver_data' => function($query) {
                $query->join('countries as c', 'c.id', '=', 'driver_data.country_id')
                    ->join('countries as cc', 'cc.id', '=', 'driver_data.dl_issue_place')
                    ->select('c.name as country_name', 'cc.name as dl_issue_place_name', 'driver_data.*');
            }
        ])->where('role', User::ROLE_DRIVER)->paginate(10);    
    }

    /**
     * Get the driver by id.
     * 
     * @param   int $id
     */
    public function getById($id)
    {
        return User::with('driver_data')->where('id', $id)->first();
    }

    /**
     * Store a newly created driver in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function store(StoreUserRequest $request)
    {
        $driver = new User($request->except('password'));
        $driver->verified = 1;
        $driver->birthday = Carbon::parse($request->birthday);
        $driver->phone_number_verified_at = Carbon::now();
        $driver->role = User::ROLE_DRIVER;
        $driver->password = Hash::make($request->password);
        
        if($request->hasFile('photo')) {
            $driver->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $driver->save();

        // Upload driver's documents
        $docs = [];
        if($request->hasFile('passport')) {
            $docs['passport'] = $this->uploadDocs($request->passport, 'user_docs');
        }

        if($request->hasFile('d_license')) {
            $docs['d_license'] = $this->uploadDocs($request->d_license, 'user_docs');
        }

        // Save additional data
        $driver->driver_data()->save(new DriverData([
            'country_id' => $request->country_id,
            'city' => $request->city,
            'dl_issue_place' => $request->dl_issue_place,
            'dl_issued_at' => Carbon::parse($request->dl_issued_at),
            'dl_expires_at' => Carbon::parse($request->dl_expires_at),
            'docs' => json_encode($docs),
            'driving_experience' => $request->driving_experience,
            'conviction' => isset($request->conviction) ? 1 : 0,
            'comment' => $request->comment,
            'was_kept_drunk' => isset($request->was_kept_drunk) ? 1 : 0,
            'dtp' => isset($request->dtp) ? 1 : 0,
            'grades' => $request->grades,
            'grades_expire_at' => Carbon::parse($request->grades_expire_at)
        ]));
    }

    /**
     * Update a specific driver.
     * 
     * @param   \App\Http\Requests\UpdateUserRequest $request
     * @param   int $id
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $driver = User::find($id);
        $driver->first_name = $request->first_name;
        $driver->last_name = $request->last_name;
        $driver->birthday = Carbon::parse($request->birthday);
        $driver->phone_number = $request->phone_number;
        $driver->email = $request->email;
        
        if($request->hasFile('photo')) {
            $driver->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $driver->save();

        // Update driver's additional data
        $driver->driver_data()->update([
            'country_id' => $request->country_id,
            'city' => $request->city,
            'dl_issue_place' => $request->dl_issue_place,
            'dl_issued_at' => Carbon::parse($request->dl_issued_at),
            'dl_expires_at' => Carbon::parse($request->dl_expires_at),
            'driving_experience' => $request->driving_experience,
            'conviction' => isset($request->conviction) ? 1 : 0,
            'comment' => $request->comment,
            'was_kept_drunk' => isset($request->was_kept_drunk) ? 1 : 0,
            'dtp' => isset($request->dtp) ? 1 : 0,
            'grades' => $request->grades,
            'grades_expire_at' => Carbon::parse($request->grades_expire_at),
        ]);
    }
}