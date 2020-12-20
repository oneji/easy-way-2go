<?php

namespace App;

use Carbon\Carbon;
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
        'place_id',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time',
        'type',
        'order'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departure_date' => 'datetime:d.m.y',
        'arrival_date' => 'datetime:d.m.y'
    ];

    /**
     * Get the route addresses's departure time.
     *
     * @param  string  $value
     * @return string
     */
    public function getDepartureTimeAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }
    
    /**
     * Get the route addresses's arrival time.
     *
     * @param  string  $value
     * @return string
     */
    public function getArrivalTimeAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    /**
     * Get the country that owns the route address.
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}
