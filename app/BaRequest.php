<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaRequest extends Model
{
    /**
     * Get the firm owner data record associated with the request.
     */
    public function firm_owner_data()
    {
        return $this->hasOne('App\BaFirmOwnerData', 'ba_request_id', 'id');
    }

    /**
     * Get the drivers for the business account request.
     */
    public function drivers()
    {
        return $this->hasMany('App\BaDriver', 'ba_request_id', 'id');
    }
    
    /**
     * Get the transport for the business account request.
     */
    public function transport()
    {
        return $this->hasOne('App\BaTransport', 'ba_request_id', 'id');
    }
}
