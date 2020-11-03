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
     * Get the driver that owns the route.
     */
    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    /**
     * Get the addresses for the route.
     */
    public function route_addresses()
    {
        return $this->hasMany('App\RouteAddress')->with('country');
    }
    
    /**
     * Get the repeats for the route.
     */
    public function route_repeats()
    {
        return $this->hasMany('App\RouteRepeat');
    }

    /**
     * Get route starting point
     * 
     * @return object
     */
    public function getStartingPoint()
    {
        return $this->route_addresses()
            ->where('type', 'forward')
            ->orderBy('departure_date')
            ->first();
    }
    
    /**
     * Get route starting point
     * 
     * @return object
     */
    public function getEndingPoint()
    {
        return $this->route_addresses()
            ->where('type', 'back')
            ->orderBy('departure_date', 'desc')
            ->first();
    }
}
