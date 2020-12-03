<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Brigadir;
use App\Driver;
use App\Http\JsonRequests\ChangeBrigadirPasswordRequest;
use App\Http\JsonRequests\UpdateBrigadirCompanyRequest;
use App\Http\JsonRequests\UpdateBrigadirRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
        return Brigadir::paginate(10);
    }

    /**
     * Get the brigadir by id.
     * 
     * @param   int $id
     */
    public function getById($id)
    {
        return Brigadir::findOrFail($id);
    }

    /**
     * Store a newly created brigadir in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function store(StoreUserRequest $request)
    {
        $brigadir = new Brigadir($request->except('password'));
        $brigadir->verified = 1;
        $brigadir->birthday = Carbon::parse($request->birthday);
        $brigadir->phone_number_verified_at = Carbon::now();
        $brigadir->password = Hash::make($request->password);
        
        if($request->hasFile('photo')) {
            $brigadir->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $brigadir->save();
    }

    /**
     * Update a specific brigadir.
     * 
     * @param   \App\Http\Requests\UpdateUserRequest $request
     * @param   int $id
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $brigadir = Brigadir::find($id);
        foreach ($request->translations as $code => $value) {
            $brigadir->setTranslation('first_name', $code, $value['first_name']);
            $brigadir->setTranslation('last_name', $code, $value['last_name']);
            $brigadir->setTranslation('company_name', $code, $value['company_name']);
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
    }

    /**
     * Get brigadir's count
     * 
     * @return collection
     */
    public function count()
    {
        return Brigadir::get()->count();
    }

    /**
     * Get brigadir's all drivers
     * 
     * @param   int $brigadirId
     * @return  collection
     */
    public function getDrivers($brigadirId)
    {
        return Driver::where('brigadir_id', $brigadirId)->get();
    }

    /**
     * Update brigadir's profile
     * 
     * @param \App\Http\JsonRequests\UpdateBrigadirRequest $request
     * @param int $id
     */
    public function updateProfile(UpdateBrigadirRequest $request, $id)
    {
        $brigadir = Brigadir::find($id);
        $brigadir->gender = $request->gender;
        $brigadir->first_name = $request->first_name;
        $brigadir->last_name = $request->last_name;
        $brigadir->phone_number = $request->phone_number;
        $brigadir->email = $request->email;
        $brigadir->birthday = Carbon::parse($request->birthday);
        $brigadir->nationality = $request->nationality;

        if($request->hasFile('photo')) {
            Storage::disk('public')->delete($brigadir->photo);
            $brigadir->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $brigadir->save();
    }

    /**
     * Update brigadir's company info
     * 
     * @param \App\Http\JsonRequests\UpdateBrigadirCompanyRequest $request
     * @param int $id
     */
    public function updateCompany(UpdateBrigadirCompanyRequest $request, $id)
    {
        $brigadir = Brigadir::find($id);
        $brigadir->company_name = $request->company_name;
        $brigadir->inn = $request->inn;
        $brigadir->save();
    }

    /**
     * Change password
     * 
     * @param \App\Http\JsonRequests\ChangeBrigadirPasswordRequest $request
     * @param int $id
     */
    public function changePassword(ChangeBrigadirPasswordRequest $request)
    {
        $client = Brigadir::find(auth('brigadir')->user()->id);
        $oldPassword = $request->old_password;
        $newPassword = $request->password;
        
        if(Hash::check($oldPassword, $client->password)) {
            $client->password = Hash::make($newPassword);
            $client->save();

            return [
                'success' => true,
                'message' => 'Пароль успешно обновлён.'
            ];
        }

        return [
            'success' => false,
            'message' => 'Старый пароль введен неверно.'
        ];
    }
}