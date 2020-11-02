<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Driver;
use App\Client;
use App\Brigadir;

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
        $type = $request->type;

        if($type === 'driver') {
            $user = Driver::where('email', $request->email)->first();
        } else if($type === 'client') {
            $user = Client::where('email', $request->email)->first();
        } else if($type === 'brigadir') {
            $user = Brigadir::where('email', $request->email)->first();
        }

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
        if (!$token = auth($type)->attempt($credentials)) {
            return [
                'ok' => false,
                'message' => 'Неверный логин или пароль.'
            ];
        }

        return [
            'ok' => true,
            'token' => $token,
            'expires_in' => auth($type)->factory()->getTTL() * 60
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