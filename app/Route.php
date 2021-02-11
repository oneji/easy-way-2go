<?php

namespace App;

use Carbon\Carbon;
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
    public function getDateAndTimeFrom()
    {
        $cities = $this->getCitiesByType('forward');

        return [
            'date' => Carbon::parse($cities['first']->departure_date)->format('d.m.y'),
            'time' => $cities['first']->departure_time
        ];
    }
    
    /**
     * Get route starting point
     * 
     * @return object
     */
    public function getDateAndTimeTo()
    {
        $cities = $this->getCitiesByType('back');

        return [
            'date' => Carbon::parse($cities['last']->arrival_date)->format('d.m.y'),
            'time' => $cities['last']->arrival_time
        ];
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

        if($addresses->count() === 0) {
            return null;
        }

        $firstCity = $addresses->first();
        $lastCity = $addresses[$addresses->keys()->last()];

        return [
            'first' => $firstCity,
            'last' => $lastCity
        ];
    }

    /**
     * Get date and time by type
     * 
     * @param string $type
     */
    public function getDateAndTimeByType($type)
    {
        $cities = $this->getCitiesByType($type);

        if(!$cities) {
            return null;
        }

        return [
            'date' => Carbon::parse($cities['first']->departure_date),
            'time' => $cities['first']->departure_time
        ];
    }

    /**
     * Get data for a newly created trip
     *  
     * @param int $tripId
     * @return array $tripData
     */
    public function getDataForTrip($tripId)
    {
        $tripData = [];
        $directions = [ 'forward', 'back' ];
        
        foreach ($directions as $direction) {
            $dateAndTime = $this->getDateAndTimeByType($direction);
            $cities = $this->getCitiesByType($direction);

            if($cities && $dateAndTime) {
                $tripData[] = [
                    'trip_id' => $tripId,
                    'date' => $dateAndTime['date'],
                    'time' => $dateAndTime['time'],
                    'from_address' => $cities['first']['address'],
                    'to_address' => $cities['last']['address'],
                    'from_country_id' => $cities['first']['country_id'],
                    'to_country_id' => $cities['last']['country_id'],
                    'type' => $direction,
                ];
            }
        }

        return $tripData;
    }
}
