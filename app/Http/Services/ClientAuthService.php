<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Traits\UploadImageTrait;
use Carbon\Carbon;
use App\User;

class ClientAuthService
{
    use UploadImageTrait;

    /**
     * Store a newly created user in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest
     * @return  \Illuminate\Http\Response
     */
    public function register(StoreUserRequest $request)
    {
        $user = new User($request->except('password'));
        $user->verification_code = mt_rand(100000, 999999);
        $user->role = User::ROLE_CLIENT;
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

    /**
     * Verify user by verification code.
     * 
     * @param   int $verificationCode
     * @return  \Illuminate\Http\Response
     */
    public function verify($verificationCode)
    {
        $user = User::where('verification_code', $verificationCode)->first();
        
        if($user) {
            $user->verified = 1;
            $user->verification_code = null;
            $user->phone_number_verified_at = Carbon::now();
            $user->save();
        } else {
            return [
                'ok' => false,
                'message' => 'Ввведен неверный код подтверждения.'
            ];    
        }

        return [
            'ok' => true,
            'message' => 'Номер телефона успешно подтвержден.',
            'user' => $user
        ];
    }
}