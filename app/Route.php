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
     * Get the transport that owns the route.
     */
    public function transport()
    {
        return $this->belongsTo('App\Transport')->with([ 'car_model', 'car_brand' ]);
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
    public function getStartingCountryWithTime()
    {
        $cities = $this->getCitiesByType('forward');

        return [
            'country' => $cities['first']->country->name .' - '. $cities['last']->country->name,
            'time' => $cities['first']->departure_time .' - '. $cities['last']->departure_time,
        ];
    }
    
    /**
     * Get route ending point
     * 
     * @return object
     */
    public function getEndingCountryWithTime()
    {
        $cities = $this->getCitiesByType('back');

        return [
            'country' => $cities['first']->country->name .' - '. $cities['last']->country->name,
            'time' => $cities['first']->departure_time .' - '. $cities['last']->departure_time,
        ];
    }

    /**
     * Get first and last cities by type
     * 
     * @param string $type
     */
    public function getCitiesByType($type)
    {
        $addresses = $this->route_addresses->where('type', $type);
        $firstCity = $addresses->first();
        $lastCity = $addresses[$addresses->keys()->last()];

        return [
            'first' => $firstCity,
            'last' => $lastCity
        ];
    }
}
