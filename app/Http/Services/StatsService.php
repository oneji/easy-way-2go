<?php

namespace App\Http\Services;

use App\User;
use App\Driver;
use App\Client;
use App\Brigadir;
use App\Transport;

class StatsService
{
    /**
     * Get all statistics
     * 
     * @return collection
     */
    public function all()
    {
        return [
            'driversCount' => Driver::all()->count(),
            'clientsCount' => Client::all()->count(),
            'brigadirsCount' => Brigadir::all()->count(),
            'transportsCount' => Transport::all()->count()
        ];
    }
}