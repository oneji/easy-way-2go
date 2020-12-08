<?php

namespace App;

use App\Scopes\PhotoScope;
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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PhotoScope);
    }
}
