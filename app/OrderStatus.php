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
     * Get cancelled status
     * 
     * @return object
     */
    public function getCancelled()
    {
        return $this->where('code', 'cancelled')->first();
    }
}
