<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripData extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the country from that owns the trip.
     */
    public function from_country()
    {
        return $this->belongsTo('App\Country', 'from_country_id', 'id');
    }
    
    /**
     * Get the country to that owns the trip.
     */
    public function to_country()
    {
        return $this->belongsTo('App\Country', 'to_country_id', 'id');
    }
}
