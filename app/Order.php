<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\Order\PassengerScope;
use App\Scopes\Order\PackageScope;
use App\Scopes\ClientScope;
use App\Scopes\MovingCargoScope;
use App\Scopes\OrderStatusScope;
use App\Scopes\PaymentStatusScope;

class Order extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_country',
        'from_address',
        'from_place_id',
        'to_country',
        'to_address',
        'to_place_id',
        'date',
        'buyer_phone_number',
        'buyer_email',
        'order_type',
        'total_price',
        'transport_id',
        'passengers_count',
        'packages_count',
        'total_weight'
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new PassengerScope);
        // static::addGlobalScope(new PackageScope);
        // static::addGlobalScope(new ClientScope);
        static::addGlobalScope(new OrderStatusScope);
        // static::addGlobalScope(new MovingCargoScope);
        // static::addGlobalScope(new PaymentStatusScope);
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
     * Get the transport that owns the order.
     */
    public function transport()
    {
        return $this->belongsTo('App\Transport');
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

    /**
     * Get the order status that owns the order.
     */
    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'order_status_id');
    }
    
    /**
     * Get the payment status that owns the order.
     */
    public function payment_status()
    {
        return $this->belongsTo('App\PaymentStatus', 'payment_status_id');
    }
    
    /**
     * Get the payment method that owns the order.
     */
    public function payment_method()
    {
        return $this->belongsTo('App\PaymentMethod', 'payment_method_id');
    }

    /**
     * The addresses that belong to the order.
     */
    public function addresses()
    {
        return $this->belongsToMany('App\RouteAddress');
    }
}
