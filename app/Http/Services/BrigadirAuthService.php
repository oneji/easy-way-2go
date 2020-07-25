<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
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
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
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

        // Save additional data
        $user->brigadir_data()->save(new ClientData([
            'id_card' => $request->id_card,
            'passport_number' => $request->passport_number,
            'passport_expires_at' => $request->passport_expires_at
        ]));

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
     * @return  array
     */
    public function verify($verificationCode)
    {
        $user = User::where('verification_code', $verificationCode)->first();
        
        if(!$user) {
            return [
                'ok' => false,
                'message' => 'Ввведен неверный код подтверждения.'
            ];   
        }

        $user->verified = 1;
        $user->verification_code = null;
        $user->phone_number_verified_at = Carbon::now();
        $user->save();

        return [
            'ok' => true,
            'message' => 'Номер телефона успешно подтвержден.',
            'user' => $user
        ];
    }

    /**
     * Authenticate the user and return jwt token.
     * 
     * @param   \App\Http\Requests\LoginUserRequest $request
     * @return  array
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)
            ->where('role', User::ROLE_BRIGADIR)
            ->first();

        if(!$user) {
            return [
                'ok' => false,
                'message' => 'Пользователя с таким email адресом не найдено.'
            ];
        }

        // Check if the user is verified
        if(!$user->verified) {
            return [
                'ok' => false,
                'message' => 'Перед тем как войти, подтвердите ваш номер телефона.'
            ];
        }

        // Authenticate the user
        if (!$token = auth('brigadir')->attempt($credentials)) {
            return [
                'ok' => false,
                'message' => 'Неверный логин или пароль.'
            ];
        }

        return [
            'ok' => true,
            'token' => $token,
            'expires_in' => auth('brigadir')->factory()->getTTL() * 60
        ];
    }
}