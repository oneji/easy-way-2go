<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Transport extends Model
{
    use HasTranslations;
    
    public $translatable = [
        'register_city'
    ];

    /**
     * Transport constants
     */
    const REGISTERED_ON_COMPANY = 0;
    const REGISTERED_ON_INDIVIDUAL = 1;
    
    /**
     * Transport doc type constants
     */
    const DOC_TYPE_PASSPORT = 'passport';
    const DOC_TYPE_TEH_OSMOTR = 'teh_osmort';
    const DOC_TYPE_INSURANCE = 'insurance';
    const DOC_TYPE_PEOPLE_LICENSE = 'people_license';
    const DOC_TYPE_CAR_PHOTOS = 'car_photos';
    const DOC_TYPE_TRAILER_PHOTOS = 'trailer_photos';

    /**
     * Maximum drivers can be bound to the transport
     */
    const DRIVER_MAX_COUNT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'register_city',
        'registered_on',
        'register_country',
        'car_number',
        'car_brand_id',
        'car_model_id',
        'year',
        'has_cmr',
        'passengers_seats',
        'cubo_metres_available',
        'kilos_available',
        'ok_for_move',
        'can_pull_trailer',
        'has_trailer',
        'pallet_transportation',
        'air_conditioner',
        'wifi',
        'tv_video',
        'disabled_people_seats',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'has_cmr' => 'boolean',
        'air_conditioner' => 'boolean',
        'wifi' => 'boolean',
        'tv_video' => 'boolean',
        'disabled_people_seats' => 'boolean',
        'pallet_transportation' => 'boolean',
        'can_pull_trailer' => 'boolean',
        'ok_for_move' => 'boolean',
        'has_trailer' => 'boolean'
    ];

    /**
     * Get the car docs for the car.
     */
    public function car_docs()
    {
        return $this->hasMany('App\CarDoc');
    }

    /**
     * The drivers that belong to the role.
     */
    public function drivers()
    {
        return $this->belongsToMany('App\Driver');
    }

    /**
     * Get the car brand that owns the transport.
     */
    public function car_brand()
    {
        return $this->belongsTo('App\CarBrand');
    }

    /**
     * Get the car model that owns the transport.
     */
    public function car_model()
    {
        return $this->belongsTo('App\CarModel');
    }
}
