<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use Carbon\Carbon;
use App\Brigadir;
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
        $user = new Brigadir($request->except('password'));
        $user->verification_code = mt_rand(100000, 999999);
        $user->role = Brigadir::ROLE_BRIGADIR;
        $user->password = Hash::make($request->password);
        
        if($request->hasFile('photo')) {
            $user->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $user->save();

        // TODO: Connect sms endpoint and the verification code via sms.
        return [ 
            'ok' => true,
            'verification_code' => $user->verification_code,
        ];
    }
}