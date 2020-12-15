<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CountryScope;
use App\Scopes\NationalityScope;

class BaFirmOwnerData extends Model
{
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
        'passport_photo' => 'object'
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CountryScope);
        static::addGlobalScope(new NationalityScope);
    }
}
