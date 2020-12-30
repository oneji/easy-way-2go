<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PaymentStatus extends Model
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
     * Get paid status
     * 
     * @return object
     */
    public static function getPaid()
    {
        return static::whereCode('paid')->first();
    }
    
    /**
     * Get not paid status
     * 
     * @return object
     */
    public static function getNotPaid()
    {
        return static::whereCode('not_paid')->first();
    }
}
