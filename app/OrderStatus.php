<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OrderStatus extends Model
{
    use HasTranslations;
    
    public $translatable = [
        'name'
    ];

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
        'name',
        'code'
    ];

    /**
     * Get future status
     * 
     * @return object
     */
    public static function getFuture()
    {
        return static::whereCode('future')->first();
    }

    /**
     * Get cancelled status
     * 
     * @return object
     */
    public static function getCancelled()
    {
        return static::whereCode('cancelled')->first();
    }
    
    /**
     * Get finished status
     * 
     * @return object
     */
    public static function getFinished()
    {
        return static::whereCode('finished')->first();
    }
}
