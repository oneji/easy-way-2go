<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankCard extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the owning bank cardable model.
     */
    public function cardable()
    {
        return $this->morphTo();
    }
}
