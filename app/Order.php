<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

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
     * Get the passengers for the order.
     */
    public function passengers()
    {
        return $this->hasMany('App\Passenger');
    }

    /**
     * Get the packages for the order.
     */
    public function packages()
    {
        return $this->hasMany('App\Package');
    }
}
