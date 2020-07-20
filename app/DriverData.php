<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverData extends Model
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
        'country_id',
        'city',
        'dl_issue_place',
        'dl_issued_at',
        'dl_expires_at',
        'driving_experience',
        'was_kept_drunk',
        'grades',
        'grades_expire_at',
    ];
}
