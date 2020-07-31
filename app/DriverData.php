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
        'docs',
        'driving_experience',
        'conviction',
        'comment',
        'was_kept_drunk',
        'dtp',
        'grades',
        'grades_expire_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'conviction' => 'boolean',
        'was_kept_drunk' => 'boolean',
        'dtp' => 'boolean',
        'docs' => 'object'
    ];
}
