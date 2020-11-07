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
}
