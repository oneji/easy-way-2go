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
     * Get the addresses for the route.
     */
    public function route_addresses()
    {
        return $this->hasMany('App\RouteAddress');
    }
    
    /**
     * Get the repeats for the route.
     */
    public function route_repeats()
    {
        return $this->hasMany('App\RouteRepeat');
    }
}
