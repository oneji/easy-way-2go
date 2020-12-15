<?php

namespace App\Http\Services;

use App\Http\Services\UploadFileService;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\UploadImageTrait;
use App\Http\Traits\UploadDocsTrait;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Driver;

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
        // return User::with([
        //     'driver_data' => function($query) {
        //         $query->with([ 'country', 'driving_experience' ])
        //             ->join('countries as cc', 'cc.id', '=', 'driver_data.dl_issue_place')
        //             ->select('cc.name as dl_issue_place_name', 'driver_data.*');
        //     }
        // ])->where('role', User::ROLE_DRIVER)->paginate(10);

        return Driver::with([ 'country', 'driving_experience' ])->paginate(10);
    }

    /**
     * Get the driver by id.
     * 
     * @param   int $id
     */
    public function getById($id)
    {
        return Driver::findOrFail($id);
    }

    /**
     * Store a newly created driver in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function store(StoreUserRequest $request)
    {
        $driver = new Driver($request->except('password'));
        $driver->password = Hash::make($request->password);

        $driver->dl_issued_at = Carbon::parse($request->dl_issued_at);
        $driver->dl_expires_at = Carbon::parse($request->dl_expires_at);
        $driver->conviction = isset($request->conviction) ? 1 : 0;
        $driver->was_kept_drunk = isset($request->was_kept_drunk) ? 1 : 0;
        $driver->dtp = isset($request->dtp) ? 1 : 0;
        $driver->grades_expire_at = Carbon::parse($request->grades_expire_at);
        
        if($request->hasFile('photo')) {
            $driver->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        if($request->hasFile('driving_license_photos')) {
            $driver->driving_license_photos = UploadFileService::uploadMultiple($request->driving_license_photos, 'driver_docs');
        }
        
        if($request->hasFile('passport_photos')) {
            $driver->passport_photos = UploadFileService::uploadMultiple($request->passport_photos, 'driver_docs');
        }
        
        $driver->save();
    }

    /**
     * Update a specific driver.
     * 
     * @param   \App\Http\Requests\UpdateUserRequest $request
     * @param   int $id
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $driver = Driver::find($id);
        $driver->first_name = $request->first_name;
        $driver->last_name = $request->last_name;
        $driver->city = $request->city;
        $driver->comment = $request->comment;
        $driver->birthday = Carbon::parse($request->birthday);
        $driver->nationality = $request->nationality;
        $driver->phone_number = $request->phone_number;
        $driver->email = $request->email;
        $driver->gender = $request->gender;
        
        if($request->hasFile('photo')) {
            $driver->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        // Upload driver's documents
        $passportDocs = [];
        $dLicenseDocs = [];

        if($request->hasFile('passport_photos')) {
            $passportDocs = UploadFileService::uploadMultiple($request->passport_photos, 'driver_docs');
        }

        if($request->hasFile('driving_license_photos')) {
            $dLicenseDocs = UploadFileService::uploadMultiple($request->driving_license_photos, 'driver_docs');
        }

        if($driver->driving_license_photos !== null) {
            $driver->driving_license_photos = array_merge($driver->driving_license_photos, $dLicenseDocs);
        } else {
            $driver->driving_license_photos = $dLicenseDocs ? $dLicenseDocs : null;
        }

        if($driver->passport_photos !== null) {
            $driver->passport_photos = array_merge($driver->passport_photos, $dLicenseDocs);
        } else {
            $driver->passport_photos = $passportDocs ? $passportDocs : null;
        }

        
        // Update driver's additional data
        $driver->country_id = $request->country_id;
        $driver->dl_issue_place = $request->dl_issue_place;
        $driver->dl_issued_at = Carbon::parse($request->dl_issued_at);
        $driver->dl_expires_at = Carbon::parse($request->dl_expires_at);
        $driver->driving_experience_id = $request->driving_experience_id;
        $driver->conviction = isset($request->conviction) ? 1 : 0;
        $driver->was_kept_drunk = isset($request->was_kept_drunk) ? 1 : 0;
        $driver->dtp = isset($request->dtp) ? 1 : 0;
        $driver->grades = $request->grades;
        $driver->grades_expire_at = Carbon::parse($request->grades_expire_at);

        $driver->save();
    }

    /**
     * Get driver's count
     */
    public function count()
    {
        return Driver::get()->count();
    }

    /**
     * Delete driver's document
     * 
     * @param   int $driverId
     * @param   int $docId
     */
    public function destroyDoc($driverId, $docId)
    {
        $driver = Driver::findOrFail($driverId);

        // Update the db
        $filteredDocs = [];
        foreach ($driver->docs as $doc) {
            if($doc->id !== $docId) {
                $filteredDocs[] = $doc;
            } else {
                // Delete the file from the storage
                Storage::disk('public')->delete($doc->file);
            }
        }

        $driver->docs = count($filteredDocs) > 0 ? $filteredDocs : null;
        $driver->save();

        return $filteredDocs;
    }
}