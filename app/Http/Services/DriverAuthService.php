<?php

namespace App\Http\Services;

use App\Http\JsonRequests\RegisterDriverRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use App\Driver;
use Carbon\Carbon;

class DriverAuthService
{
    use UploadImageTrait;

    /**
     * Store a newly created user in the db.
     * 
     * @param   \App\Http\JsonRequests\RegisterDriverRequest $request
     * @return  array
     */
    public function register(RegisterDriverRequest $request)
    {
        $driver = new Driver($request->except('password'));
        $driver->verification_code = mt_rand(100000, 999999);
        $driver->password = Hash::make($request->password);
        $driver->birthday = Carbon::parse($request->birthday);
        $driver->dl_issued_at = Carbon::parse($request->dl_issued_at);
        $driver->dl_expires_at = Carbon::parse($request->dl_expires_at);
        $driver->grades_expire_at = Carbon::parse($request->grades_expire_at);
        
        if($request->hasFile('photo')) {
            $driver->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $driver->save();

        // TODO: Connect sms endpoint and the verification code via sms.
        return [ 
            'ok' => true,
            'verification_code' => $driver->verification_code,
        ];
    }
}