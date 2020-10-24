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
                $query->with([ 'country', 'driving_experience' ])
                    ->join('countries as cc', 'cc.id', '=', 'driver_data.dl_issue_place')
                    ->select('cc.name as dl_issue_place_name', 'driver_data.*');
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
                $query->with([ 'country', 'driving_experience' ])
                    ->join('countries as cc', 'cc.id', '=', 'driver_data.dl_issue_place')
                    ->select('cc.name as dl_issue_place_name', 'driver_data.*');
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

        foreach ($request->translations as $code => $value) {
            $driver->setTranslation('first_name', $code, $value['first_name']);
            $driver->setTranslation('last_name', $code, $value['last_name']);
        }
        
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
        $driverData = new DriverData(); 
        $driverData->country_id = $request->country_id;
        foreach ($request->translations as $code => $value) {
            $driverData->setTranslation('city', $code, $value['city']);
            $driverData->setTranslation('comment', $code, $value['comment']);
        }
        $driverData->dl_issue_place = $request->dl_issue_place;
        $driverData->dl_issued_at = Carbon::parse($request->dl_issued_at);
        $driverData->dl_expires_at = Carbon::parse($request->dl_expires_at);
        $driverData->docs = count($mergedDocs) > 0 ? $mergedDocs : null;
        $driverData->driving_experience_id = $request->driving_experience_id;
        $driverData->conviction = isset($request->conviction) ? 1 : 0;
        $driverData->was_kept_drunk = isset($request->was_kept_drunk) ? 1 : 0;
        $driverData->dtp = isset($request->dtp) ? 1 : 0;
        $driverData->grades = $request->grades;
        $driverData->grades_expire_at = Carbon::parse($request->grades_expire_at);
        $driverData->user_id = $driver->id;
        $driverData->save();
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
        foreach ($request->translations as $code => $value) {
            $driver->setTranslation('first_name', $code, $value['first_name']);
            $driver->setTranslation('last_name', $code, $value['last_name']);
        }
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
        $driverData = DriverData::where('user_id', $driver->id)->first();
        $driverData->country_id = $request->country_id;
        foreach ($request->translations as $code => $value) {
            $driverData->setTranslation('city', $code, $value['city']);
            $driverData->setTranslation('comment', $code, $value['comment']);
        }
        $driverData->dl_issue_place = $request->dl_issue_place;
        $driverData->dl_issued_at = Carbon::parse($request->dl_issued_at);
        $driverData->dl_expires_at = Carbon::parse($request->dl_expires_at);
        $driverData->docs = count($mergedDocs) > 0 ? $mergedDocs : null;
        $driverData->driving_experience_id = $request->driving_experience_id;
        $driverData->conviction = isset($request->conviction) ? 1 : 0;
        $driverData->was_kept_drunk = isset($request->was_kept_drunk) ? 1 : 0;
        $driverData->dtp = isset($request->dtp) ? 1 : 0;
        $driverData->grades = $request->grades;
        $driverData->grades_expire_at = Carbon::parse($request->grades_expire_at);
        $driverData->user_id = $driver->id;
        $driverData->save();
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