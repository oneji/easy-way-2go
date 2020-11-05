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
        return $this->hasMany('App\RouteAddress');
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
    public function getStartingPointWithTime()
    {
        $addresses = $this->route_addresses->where('type', 'forward');
        $firstCity = null;
        $lastCity = null;

        foreach ($addresses as $idx => $item) {
            if($idx === 0) {
                $firstCity = $item;
            }

            if($idx === $addresses->count() - 1) {
                $lastCity = $item;
            }
        }

        return [
            'country' => $firstCity->country->name .' - '. $lastCity->country->name,
            'time' => $firstCity->departure_time .' - '. $lastCity->departure_time
        ];
    }
    
    /**
     * Get route ending point
     * 
     * @return object
     */
    public function getEndingPointWithTime()
    {
        $addresses = $this->route_addresses->where('type', 'back');
        $firstCity = null;
        $lastCity = null;

        foreach ($addresses as $idx => $item) {
            if($idx === 0) {
                $firstCity = $item;
            }

            if($idx === $addresses->count() - 1) {
                $lastCity = $item;
            }
        }

        return [
            'country' => $firstCity,
            'time' => $firstCity
        ];
    }
}
