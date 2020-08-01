<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
                    ->join('driving_experiences as de', 'de.id', '=', 'driver_data.driving_experience')
                    ->select('c.name as country_name', 'cc.name as dl_issue_place_name', 'driver_data.*', 'de.name as driving_experience_name');
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
        return User::with([
            'driver_data' => function($query) {
                $query->join('countries as c', 'c.id', '=', 'driver_data.country_id')
                    ->join('countries as cc', 'cc.id', '=', 'driver_data.dl_issue_place')
                    ->select('c.name as country_name', 'cc.name as dl_issue_place_name', 'driver_data.*');
            },
        ])
        ->where('role', User::ROLE_DRIVER)->where('users.id', $id)->first();
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
        $passportDocs = [];
        $dLicenseDocs = [];
        if($request->hasFile('passport')) {
            $passportDocs = $this->uploadDocs($request->passport, 'user_docs', 'passport');
        }

        if($request->hasFile('d_license')) {
            $dLicenseDocs = $this->uploadDocs($request->d_license, 'user_docs', 'd_license');
        }

        $mergedDocs = array_merge($passportDocs, $dLicenseDocs);

        // Save additional data
        $driver->driver_data()->save(new DriverData([
            'country_id' => $request->country_id,
            'city' => $request->city,
            'dl_issue_place' => $request->dl_issue_place,
            'dl_issued_at' => Carbon::parse($request->dl_issued_at),
            'dl_expires_at' => Carbon::parse($request->dl_expires_at),
            'docs' => count($mergedDocs) > 0 ? $mergedDocs : null,
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
        $driver->nationality = $request->nationality;
        $driver->phone_number = $request->phone_number;
        $driver->email = $request->email;
        $driver->gender = $request->gender;
        
        if($request->hasFile('photo')) {
            $driver->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $driver->save();

        // Upload driver's documents
        $passportDocs = [];
        $dLicenseDocs = [];
        $mergedDocs = [];

        if($request->hasFile('passport')) {
            $passportDocs = $this->uploadDocs($request->passport, 'user_docs', 'passport');
        }

        if($request->hasFile('d_license')) {
            $dLicenseDocs = $this->uploadDocs($request->d_license, 'user_docs', 'd_license');
        }

        if($driver->driver_data->docs !== null) {
            $mergedDocs = array_merge($driver->driver_data->docs, $dLicenseDocs, $passportDocs);
        } else {
            $mergedDocs = array_merge($passportDocs, $dLicenseDocs);
        }

        
        // Update driver's additional data
        $driver->driver_data()->update([
            'country_id' => $request->country_id,
            'city' => $request->city,
            'dl_issue_place' => $request->dl_issue_place,
            'dl_issued_at' => Carbon::parse($request->dl_issued_at),
            'dl_expires_at' => Carbon::parse($request->dl_expires_at),
            'docs' => count($mergedDocs) > 0 ? json_encode($mergedDocs) : null,
            'driving_experience' => $request->driving_experience,
            'conviction' => isset($request->conviction) ? 1 : 0,
            'comment' => $request->comment,
            'was_kept_drunk' => isset($request->was_kept_drunk) ? 1 : 0,
            'dtp' => isset($request->dtp) ? 1 : 0,
            'grades' => $request->grades,
            'grades_expire_at' => Carbon::parse($request->grades_expire_at),
        ]);
    }

    /**
     * Get driver's count
     */
    public function count()
    {
        return User::where('role', User::ROLE_DRIVER)->get()->count();
    }

    /**
     * Delete driver's document
     * 
     * @param   int $driverId
     * @param   int $docId
     */
    public function destroyDoc($driverId, $docId)
    {
        $driverData = DriverData::where('user_id', $driverId)->first();

        // Update the db
        $filteredDocs = [];
        foreach ($driverData->docs as $doc) {
            if($doc->id !== $docId) {
                $filteredDocs[] = $doc;
            } else {
                // Delete the file from the storage
                Storage::disk('public')->delete($doc->file);
            }
        }

        $driverData->docs = count($filteredDocs) > 0 ? $filteredDocs : null;
        $driverData->save();

        return $filteredDocs;
    }
}