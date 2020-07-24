<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * User roles
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENT = 'client';
    const ROLE_DRIVER = 'driver';
    const ROLE_BRIGADIR = 'brigadir';

    /**
     * User genders
     */
    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    const GENDER_OTHER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'nationality',
        'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the client data associated with the user.
     */
    public function client_data()
    {
        return $this->hasOne('App\ClientData');
    }

    /**
     * Get the driver data associated with the user.
     */
    public function driver_data()
    {
        return $this->hasOne('App\DriverData');
    }

    /**
     * Get the brigadir data associated with the user.
     */
    public function brigadir_data()
    {
        return $this->hasOne('App\BrigadirData');
    }
}
