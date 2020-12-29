<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'amount'
    ];

    /**
     * Get all of the expense's photos.
     */
    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable');
    }
}
