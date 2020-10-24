<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Carbon\Carbon;
use App\BrigadirData;

class BrigadirService
{
    use UploadImageTrait;

    /**
     * Get all the brigadirs
     * 
     * @return collection
     */
    public function all()
    {
        return User::with('brigadir_data')->where('role', User::ROLE_BRIGADIR)->paginate(10);
    }

    /**
     * Get the brigadir by id.
     * 
     * @param   int $id
     */
    public function getById($id)
    {
        return User::with('brigadir_data')->where('role', User::ROLE_BRIGADIR)->where('id', $id)->first();
    }

    /**
     * Store a newly created brigadir in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function store(StoreUserRequest $request)
    {
        $brigadir = new User($request->except('password'));
        $brigadir->verified = 1;
        $brigadir->birthday = Carbon::parse($request->birthday);
        $brigadir->phone_number_verified_at = Carbon::now();
        $brigadir->role = User::ROLE_BRIGADIR;
        $brigadir->password = Hash::make($request->password);

        foreach ($request->translations as $code => $value) {
            $brigadir->setTranslation('first_name', $code, $value['first_name']);
            $brigadir->setTranslation('last_name', $code, $value['last_name']);
        }
        
        if($request->hasFile('photo')) {
            $brigadir->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $brigadir->save();

        $brigadirData = new BrigadirData();
        $brigadirData->inn = $request->inn;
        $brigadirData->user_id = $brigadir->id;
        foreach ($request->translations as $code => $value) {
            $brigadirData->setTranslation('company_name', $code, $value['company_name']);
        }
        $brigadirData->save();
    }

    /**
     * Update a specific brigadir.
     * 
     * @param   \App\Http\Requests\UpdateUserRequest $request
     * @param   int $id
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $brigadir = User::find($id);
        foreach ($request->translations as $code => $value) {
            $brigadir->setTranslation('first_name', $code, $value['first_name']);
            $brigadir->setTranslation('last_name', $code, $value['last_name']);
        }
        $brigadir->birthday = Carbon::parse($request->birthday);
        $brigadir->nationality = $request->nationality;
        $brigadir->phone_number = $request->phone_number;
        $brigadir->email = $request->email;
        $brigadir->gender = $request->gender;
        
        if($request->hasFile('photo')) {
            $brigadir->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $brigadir->save();

        // Update brigadir's additional data
        $brigadirData = BrigadirData::where('user_id', $brigadir->id)->first();
        $brigadirData->inn = $request->inn;
        foreach ($request->translations as $code => $value) {
            $brigadirData->setTranslation('company_name', $code, $value['company_name']);
        }
        $brigadirData->save();
    }

    /**
     * Get brigadir's count
     * 
     * @return collection
     */
    public function count()
    {
        return User::where('role', User::ROLE_BRIGADIR)->get()->count();
    }

    /**
     * Get brigadir's all drivers
     * 
     * @param   int $brigadirId
     * @return  collection
     */
    public function getDrivers($brigadirId)
    {
        return User::where('role', User::ROLE_DRIVER)->where('brigadir_id', $brigadirId)->get();
    }
}