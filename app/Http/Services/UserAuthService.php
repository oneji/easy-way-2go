<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;

class UserAuthService
{
    /**
     * Authenticate the user and return jwt token.
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  array
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

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
        if (!$token = auth('client')->attempt($credentials)) {
            return [
                'ok' => false,
                'message' => 'Неверный логин или пароль.'
            ];
        }

        return [
            'ok' => true,
            'token' => $token,
            'user' => $user,
            'expires_in' => auth('client')->factory()->getTTL() * 60
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
}