<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Scopes\CountryScope;
use App\Scopes\NationalityScope;
use App\Scopes\DrivingExperienceScope;

class BaDriver extends Model
{
    use HasTranslations;
    
    public $translatable = [
        'first_name',
        'last_name',
        'city',
        'comment'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'driving_license_photos' => 'object',
        'passport_photos' => 'object'
    ];

    /**
     * Get the country that owns the driver data.
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Get the nationality that owns the driver data.
     */
    public function nationality()
    {
        return $this->belongsTo('App\Country', 'nationality', 'id');
    }
    
    /**
     * Get the nationality that owns the driver data.
     */
    public function driving_experience()
    {
        return $this->belongsTo('App\DrivingExperience');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CountryScope);
        static::addGlobalScope(new NationalityScope);
        static::addGlobalScope(new DrivingExperienceScope);
    }

    /**
     * Get driver's full name
     */
    public function getFullName()
    {
        return $this->first_name .' '. $this->last_name;
    }
}
