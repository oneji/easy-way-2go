<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    /**
     * Route constants
     */
    const TYPE_FORWARD = 'forward';
    const TYPE_BACK = 'back';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'address',
        'departure_time',
        'arrival_time',
        'type'
    ];
}
