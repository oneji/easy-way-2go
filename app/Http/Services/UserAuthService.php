<?php

namespace App\Http\Services;

use App\Http\JsonRequests\LoginUserRequest;
use Carbon\Carbon;
use App\Driver;
use App\Client;
use App\Brigadir;
use App\Http\JsonRequests\VerifyCodeRequest;
use App\Jobs\SyncUserToMongoChatJob;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Exception;
use Illuminate\Support\Facades\DB;

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
            $token = auth($user->role)->claims([ 'user' => $user ])->login($user);
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
        $driver = Driver::with('notifications')
            ->where('email', $login)
            ->orWhere('phone_number', $login)
            ->first();
        
        $client = Client::with('notifications')
            ->where('email', $login)
            ->orWhere('phone_number', $login)
            ->first();

        $brigadir = Brigadir::with('notifications')
            ->where('email', $login)
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
        $token = auth($user->role)->claims([ 'user' => $user ])->login($user);

        return [
            'success' => true,
            'message' => 'Phone number verification is successfull.',
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
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function refreshToken(Request $request)
    {
        try {
            // Get the user from token
            $payload = JWTAuth::parseToken()->getPayload();

            return [
                'success' => true,
                'status' => 200,
                'token' => auth($request->role)->refresh()
            ];
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return [
                    'success' => false,
                    'status' => 401,
                    'message' => 'Token is invalid'
                ];
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return [
                    'success' => true,
                    'status' => 200,
                    'token' => auth($request->role)->refresh()
                ];
            } else {
                return [
                    'success' => false,
                    'status' => 401,
                    'message' => 'Token is not provided'
                ];
            }
        }
    }

    /**
     * Sync all user's to the mongo db
     * 
     * @param string $key
     */
    public function syncAllToMongo($key)
    {
        if($key === md5(User::SYNC_KEY)) {
            // Prepare queries to union them
            $clients = DB::table('clients')->select('id', 'first_name', 'last_name', 'email', 'role', 'photo', 'phone_number');
            $drivers = DB::table('drivers')->select('id', 'first_name', 'last_name', 'email', 'role', 'photo', 'phone_number');
    
            $allUsers = DB::table('brigadirs')
                ->select('id', 'first_name', 'last_name', 'email', 'role', 'photo', 'phone_number')
                ->union($clients)
                ->union($drivers)
                ->orderBy('role')
                ->get();
    
            foreach ($allUsers as $user) {
                SyncUserToMongoChatJob::dispatch($user);
            }
    
            return [
                'success' => true,
                'status' => 200
            ];
        }

        return [
            'success' => false,
            'status' => 422
        ];
    }
}