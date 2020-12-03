<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovingCargo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cargo_type_id',
        'length',
        'width',
        'height',
        'weight',
        'packaging'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get all of the cargo's photos.
     */
    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable');
    }
}
