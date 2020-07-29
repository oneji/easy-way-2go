<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
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
        'car_passport',
        'teh_osmotr',
        'insurance',
        'people_license',
        'car_photos',
        'trailer_photos',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'car_passport' => 'array',
        'teh_osmort' => 'array',
        'insurance' => 'array',
        'people_license' => 'array',
        'car_photos' => 'array',
        'trailer_photos' => 'array'
    ];

    /**
     * Get the car that owns the image.
     */
    public function car()
    {
        return $this->belongsTo('App\Transport');
    }
}
