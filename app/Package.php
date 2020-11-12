<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'photos' => 'object'
    ];
    
    /**
     * Package dimension type 
     */
    const TYPE_SAME = 'same';
    const TYPE_DIFFERENT = 'different';
}
