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
        
        if($request->hasFile('photo')) {
            $brigadir->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $brigadir->save();

        // Save additional data
        $brigadir->brigadir_data()->save(new BrigadirData([
            'company_name' => $request->company_name,
            'inn' => $request->inn
        ]));
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
        $brigadir->first_name = $request->first_name;
        $brigadir->last_name = $request->last_name;
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
        $brigadir->brigadir_data()->update([
            'company_name' => $request->company_name,
            'inn' => $request->inn
        ]);
    }

    /**
     * Get brigadir's count
     */
    public function count()
    {
        return User::where('role', User::ROLE_BRIGADIR)->get()->count();
    }
}