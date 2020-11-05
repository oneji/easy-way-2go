<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BaMainDriverData extends Model
{
    use HasTranslations;
    
    public $translatable = [
        'first_name',
        'last_name',
        'city',
        'comment'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
