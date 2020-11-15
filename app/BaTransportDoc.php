<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaTransportDoc extends Model
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
     * Get the transport that owns the doc.
     */
    public function transport()
    {
        return $this->belongsTo('App\BaTransport');
    }

    /**
     * Get the transport docs for the transport.
     */
    public function docs()
    {
        return $this->hasMany('App\BaTransportDoc', 'ba_transport_id', 'id');
    }
}
