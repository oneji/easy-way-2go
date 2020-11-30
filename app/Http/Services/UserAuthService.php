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
                'success' => false,
                'message' => 'Пользователя с таким email адресом не найдено.'
            ];
        }

        // Check if the user is verified
        if(!$user->verified) {
            return [
                'success' => false,
                'message' => 'Перед тем как войти, подтвердите ваш номер телефона.'
            ];
        }

        // Authenticate the user
        if (!$token = auth($user->role)->attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'Неверный логин или пароль.'
            ];
        }

        return [
            'success' => true,
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
        $driver = Driver::where('verification_code', $verificationCode)->first();
        $client = Client::where('verification_code', $verificationCode)->first();
        $brigadir = Brigadir::where('verification_code', $verificationCode)->first();
        
        if($driver) {
            $user = $driver;
        } else if($client) {
            $user = $client;
        } else if($brigadir) {
            $user = $brigadir;
        };

        $user->verified = 1;
        $user->verification_code = null;
        $user->phone_number_verified_at = Carbon::now();
        $user->save();

        return [
            'success' => true,
            'message' => 'Номер телефона успешно подтвержден.',
            'data' => $user
        ];
    }
}