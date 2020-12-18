<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use App\Client;
use App\Jobs\RegisterJob;
use App\Jobs\SyncUserToMongoChatJob;

class ClientAuthService
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
        $client = new Client($request->except('password'));
        $client->verification_code = mt_rand(100000, 999999);
        $client->password = Hash::make($request->password);
        $client->role = 'client';
        
        if($request->hasFile('photo')) {
            $client->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $client->save();

        SyncUserToMongoChatJob::dispatch($client->toArray());
        RegisterJob::dispatch($client->email, $client->verification_code);        

        // TODO: Connect sms endpoint and the verification code via sms.
        return [ 
            'success' => true,
            'verification_code' => $client->verification_code,
            'data' => $client
        ];
    }
}