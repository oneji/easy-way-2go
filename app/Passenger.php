<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ActiveScope;

class Passenger extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope);
    }

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
        'gender',
        'first_name',
        'last_name',
        'birthday',
        'nationality',
        'id_card',
        'id_card_expires_at',
        'passport_number',
        'passport_expires_at'
    ];

    /**
     * Get the nationality country for the passenger.
     */
    public function nationality_country()
    {
        return $this->belongsTo('App\Country', 'nationality', 'id');
    }

    /**
     * Get the orders for the passenger.
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }
}
