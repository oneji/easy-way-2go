<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BaFirmOwnerData extends Model
{
    use HasTranslations;
    
    public $translatable = [
        'company_name',
        'first_name',
        'last_name',
        'city'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
