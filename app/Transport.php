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
     * Get the car images for the car.
     */
    public function car_images()
    {
        return $this->hasMany('App\CarImage');
    }
}
