<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Trip extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transport_id',
        'route_id',
        'from_country_id',
        'from_address',
        'to_country_id',
        'to_address',
        'date',
        'time',
        'type',
        'status_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime:d.m.y',
    ];

    /**
     * Get the trip's time.
     *
     * @param  string  $value
     * @return string
     */
    public function getTimeAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    /**
     * Get the transport that owns the trip.
     */
    public function transport()
    {
        return $this->belongsTo('App\Transport');
    }
    
    /**
     *  Get the orders that belong to the trip.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    
    /**
     *  Get the expenses that belong to the trip.
     */
    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }

    /**
     * Get the status that owns the trip.
     */
    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'status_id');
    }

    /**
     * Get the drivers for the trip.
     */
    public function drivers()
    {
        return $this->belongsToMany('App\Driver');
    }

    /**
     * Get all of the transactions for the trip.
     */
    public function transactions()
    {
        return $this->hasManyThrough('App\Transaction', 'App\Order');
    }

    /**
     * Get formatted data
     */
    public function getFormattedData()
    {
        return TripData::with([ 'from_country', 'to_country' ])
            ->whereTripId($this->id)
            ->whereType($this->type)
            ->select(
                'date',
                'time',
                'from_address',
                'to_address',
                'from_country_id',
                'to_country_id'
            )
            ->first();
    }
}
