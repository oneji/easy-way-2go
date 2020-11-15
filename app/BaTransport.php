<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BaTransport extends Model
{
    use HasTranslations;
    
    public $translatable = [
        'register_city'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
     * Get the docs for the transport.
     */
    public function docs()
    {
        return $this->hasMany('App\BaTransport', 'ba_transport_id', 'id');
    }

    /**
     * Get the car brand that owns the transport.
     */
    public function brand()
    {
        return $this->belongsTo('App\CarBrand', 'car_brand_id', 'id');
    }

    /**
     * Get the car model that owns the transport.
     */
    public function car_model()
    {
        return $this->belongsTo('App\CarModel', 'car_model_id', 'id');
    }
}
