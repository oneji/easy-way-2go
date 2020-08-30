<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use Carbon\Carbon;
use App\User;
use JWTAuth;
use App\BrigadirData;

class BrigadirAuthService
{
    use UploadImageTrait;

    /**
     * Store a newly created user in the db.
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  array
     */
    public function register(Request $request)
    {
        $user = new User($request->except('password'));
        $user->verification_code = mt_rand(100000, 999999);
        $user->role = User::ROLE_BRIGADIR;
        $user->password = Hash::make($request->password);
        
        if($request->hasFile('photo')) {
            $user->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $user->save();

        // Save additional data
        $user->brigadir_data()->save(new BrigadirData([
            'company_name' => $request->company_name,
            'inn' => $request->inn
        ]));

        // TODO: Connect sms endpoint and the verification code via sms.
        return [ 
            'ok' => true,
            'verification_code' => $user->verification_code,
        ];
    }
}