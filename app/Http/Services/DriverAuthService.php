<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Traits\UploadImageTrait;
use Carbon\Carbon;
use App\User;
use JWTAuth;
use App\DriverData;

class DriverAuthService
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
        $user->role = User::ROLE_DRIVER;
        $user->password = Hash::make($request->password);
        
        if($request->hasFile('photo')) {
            $user->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $user->save();

        // Save additional data
        $user->driver_data()->save(new DriverData([
            'country_id' => $request->country_id,
            'city' => $request->city,
            'dl_issue_place' => $request->dl_issue_place,
            'dl_issued_at' => $request->dl_issued_at,
            'dl_expires_at' => $request->dl_expires_at,
            'driving_experience' => $request->driving_experience,
            'conviction' => isset($request->conviction) ? 1 : null,
            'comment' => $request->comment,
            'was_kept_drunk' => isset($request->was_kept_drunk) ? 1 : null,
            'dtp' => isset($request->dtp) ? 1 : null,
            'grades' => $request->grades,
            'grades_expire_at' => $request->grades_expire_at,
        ]));

        // TODO: Connect sms endpoint and the verification code via sms.
        return [ 
            'ok' => true,
            'verification_code' => $user->verification_code,
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
            ->where('role', User::ROLE_DRIVER)
            ->first();

        if(!$user) {
            return [
                'ok' => false,
                'message' => 'Пользователь с таким email адресом не найдено.'
            ];
        }

        if(!$user->verified) {
            return [
                'ok' => false,
                'message' => 'Перед тем как войти, подтвердите ваш номер телефона.'
            ];
        }
        
        if (!$token = auth('driver')->attempt($credentials)) {
            return [
                'ok' => false,
                'message' => 'Неверный логин или пароль.'
            ];
        }

        return [
            'ok' => true,
            'token' => $token,
            'expires_in' => auth('driver')->factory()->getTTL() * 60
        ];
    }
}