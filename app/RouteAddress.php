<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RouteAddress extends Model
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
        'country_id',
        'address',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time',
        'type'
    ];
}
