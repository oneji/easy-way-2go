<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime:d.m.Y'
    ];

    /**
     * Get the payment method that owns the order.
     */
    public function payment_method()
    {
        return $this->belongsTo('App\PaymentMethod', 'payment_method_id');
    }
}
