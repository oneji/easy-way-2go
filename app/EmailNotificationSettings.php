<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailNotificationSettings extends Model
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
    protected $fillable = [
        'data',
        'user_id',
        'user_role'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'object',
    ];
}
