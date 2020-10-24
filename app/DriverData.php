<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DriverData extends Model
{
    use HasTranslations;
    
    public $translatable = [
        'city',
        'comment',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'conviction' => 'boolean',
        'was_kept_drunk' => 'boolean',
        'dtp' => 'boolean',
        'docs' => 'object'
    ];

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
