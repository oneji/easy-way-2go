<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Scopes\Order\PassengerScope;
use App\Scopes\Order\PackageScope;
use App\Scopes\ClientScope;

class Order extends Model
{
    use HasTranslations;
    
    public $translatable = [
        'from_address',
        'to_address'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PassengerScope);
        static::addGlobalScope(new PackageScope);
        static::addGlobalScope(new ClientScope);
    }

    /**
     * Get the passengers for the order.
     */
    public function passengers()
    {
        return $this->belongsToMany('App\Passenger');
    }

    /**
     * Get the client that owns the order.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    
    /**
     * Get the country from that owns the order.
     */
    public function country_from()
    {
        return $this->belongsTo('App\Country', 'from_country', 'id');
    }
    
    /**
     * Get the country to that owns the order.
     */
    public function country_to()
    {
        return $this->belongsTo('App\Country', 'to_country', 'id');
    }

    /**
     * Get the packages for the order.
     */
    public function packages()
    {
        return $this->hasMany('App\Package');
    }
}