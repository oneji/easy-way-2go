<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarDoc extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_path',
        'doc_type',
    ];

    /**
     * Get the car that owns the image.
     */
    public function car()
    {
        return $this->belongsTo('App\Transport');
    }
}
