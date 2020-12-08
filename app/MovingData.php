<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovingData extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_floor',
        'to_floor',
        'time',
        'movers_count',
        'parking',
        'parking_working_hours',
        'order_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'parking' => 'boolean'
    ];

    /**
     * Get the cargos for the moving data.
     */
    public function cargos()
    {
        return $this->hasMany('App\MovingCargo', 'moving_data_id');
    }
}
