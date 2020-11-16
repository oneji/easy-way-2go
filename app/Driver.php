<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;

class Driver extends Authenticatable implements JWTSubject
{
    use HasTranslations;
    
    public $translatable = [
        'first_name',
        'last_name',
        'city',
        'comment',
    ];

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
        'gender',
        'country_id',
        'dl_issue_place',
        'dl_issued_at',
        'dl_expires_at',
        'docs',
        'driving_experience_id',
        'conviction',
        'was_kept_drunk',
        'dtp',
        'grades',
        'grades_expire_at',
        'nationality',
        'city',
        'comment'
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
        'verified' => 'boolean',
        'conviction' => 'boolean',
        'was_kept_drunk' => 'boolean',
        'dtp' => 'boolean',
        'driving_license_photos' => 'object',
        'passport_photos' => 'object',
    ];

    /**
     * Get driver's full name
     */
    public function getFullName()
    {
        return $this->first_name .' '. $this->last_name;
    }

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
     * Get the country that owns the driver data.
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Get the driving experience that owns the driver data.
     */
    public function driving_experience()
    {
        return $this->belongsTo('App\DrivingExperience');
    }
}
