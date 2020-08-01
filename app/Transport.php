<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'registered_on',
        'register_country',
        'register_city',
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
}
