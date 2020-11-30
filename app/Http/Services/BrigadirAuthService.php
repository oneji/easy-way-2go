<?php

namespace App\Http\Services;

use App\Http\JsonRequests\RegisterBrigadirRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use App\Brigadir;

class BrigadirAuthService
{
    use UploadImageTrait;

    /**
     * Store a newly created user in the db.
     * 
     * @param   \App\Http\JsonRequests\RegisterBrigadirRequest $request
     * @return  array
     */
    public function register(RegisterBrigadirRequest $request)
    {
        $user = new Brigadir($request->except('password'));
        $user->verification_code = mt_rand(100000, 999999);
        $user->role = 'brigadir';
        $user->password = Hash::make($request->password);
        
        if($request->hasFile('photo')) {
            $user->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $user->save();

        // TODO: Connect sms endpoint and the verification code via sms.
        return [ 
            'success' => true,
            'verification_code' => $user->verification_code,
        ];
    }
}