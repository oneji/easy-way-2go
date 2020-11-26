<?php

namespace App\Http\Services;

use App\Http\JsonRequests\LoginUserRequest;
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
     * @param   \App\Http\JsonRequests\LoginUserRequest $request
     * @return  array
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        
        $user = $this->findUser($credentials['email']);

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
        if (!$token = auth($user->role)->attempt($credentials)) {
            return [
                'ok' => false,
                'message' => 'Неверный логин или пароль.'
            ];
        }

        return [
            'ok' => true,
            'token' => $token,
            'user' => $user,
            'expires_in' => auth($user->role)->factory()->getTTL() * 60
        ];
    }

    /**
     * Find the user from all tables
     * 
     * @param string $email
     */
    public function findUser($email)
    {
        $driver = Driver::where('email', $email)->first();
        $client = Client::where('email', $email)->first();
        $brigadir = Brigadir::where('email', $email)->first();
        
        if($driver) return $driver;
        else if($client) return $client;
        else if($brigadir) return $brigadir;

        return null;
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