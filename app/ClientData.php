<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientData extends Model
{
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
        'id_card', 'passport_number', 'passport_expires_at',
    ];
}
