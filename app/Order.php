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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_country',
        'from_address',
        'to_country',
        'to_address',
        'date',
        'buyer_phone_number',
        'buyer_email',
        'order_type',
        'total_price'
    ];

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

    /**
     * Get the moving data associated with the order.
     */
    public function moving_data()
    {
        return $this->hasOne('App\MovingData');
    }

    /**
     * Get all of the cargos for the order.
     */
    public function cargos()
    {
        return $this->hasManyThrough('App\MovingCargo', 'App\MovingData');
    }
}
