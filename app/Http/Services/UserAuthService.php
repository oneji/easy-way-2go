<?php

namespace App\Http\Services;

use App\Http\JsonRequests\LoginUserRequest;
use Carbon\Carbon;
use App\User;
use App\Driver;
use App\Client;
use App\Brigadir;
use App\Http\JsonRequests\VerifyCodeRequest;
use Illuminate\Support\Facades\Hash;

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
        $credentials = $request->only('login', 'password');
        
        $user = $this->findUser($credentials['login']);

        if(!$user) {
            return [
                'success' => false,
                'status' => 422,
                'message' => 'User with these credentials could not be found.'
            ];
        }

        // Authenticate the user
        if(Hash::check($credentials['password'], $user->password)) {
            $token = auth($user->role)->claims(['user' => $user])->login($user);
        } else {
            return [
                'success' => false,
                'status' => 422,
                'message' => 'Login or password is incorrect.'
            ];
        }

        return [
            'status' => 200,
            'success' => true,
            'token' => $token,
            'user' => $user,
            'expires_in' => auth($user->role)->factory()->getTTL() * 60,
        ];
    }

    /**
     * Find the user from all tables
     * 
     * @param string $login
     */
    public function findUser($login)
    {
        $driver = Driver::where('email', $login)
            ->orWhere('phone_number', $login)
            ->first();
        
        $client = Client::where('email', $login)
            ->orWhere('phone_number', $login)
            ->first();

        $brigadir = Brigadir::where('email', $login)
            ->orWhere('phone_number', $login)
            ->first();
        
        if($driver) return $driver;
        if($client) return $client;
        if($brigadir) return $brigadir;

        return null;
    }

    /**  
     * Verify user by verification code.
     * 
     * @param   \App\Http\JsonRequests\VerifyCodeRequest $request
     * @return  array
     */
    public function verify(VerifyCodeRequest $request)
    {
        $user = Client::where('verification_code', $request->code)->first();

        if(!$user) {
            return [
                'success' => false,
                'message' => 'Wrong verification code provided.'
            ];
        }

        $user->verified = 1;
        $user->verification_code = null;
        $user->phone_number_verified_at = Carbon::now();
        $user->save();

        // Authenticate the user
        $token = auth($user->role)->login($user);

        return [
            'success' => true,
            'message' => 'Phone number verification is successful.',
            'user' => $user,
            'token' => $token,
            'expires_in' => auth($user->role)->factory()->getTTL() * 60
        ];
    }

    /**
     * Fetch user from token
     */
    public function me()
    {
        $client = auth('client')->user();
        $driver = auth('driver')->user();
        $brigadir = auth('brigadir')->user();

        if($client) return $client;
        if($driver) return $driver;
        if($brigadir) return $brigadir;
    }

    /**
     * Refresh token
     */
    public function refreshToken()
    {
        $client = auth('client')->user();
        $driver = auth('driver')->user();
        $brigadir = auth('brigadir')->user();

        if($client) return auth('client')->refresh();
        if($driver) return auth('driver')->refresh();
        if($brigadir) return auth('brigadir')->refresh();
    }
}