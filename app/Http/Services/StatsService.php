<?php

namespace App\Http\Services;
use App\User;
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
            'driversCount' => User::where('role', User::ROLE_DRIVER)->get()->count(),
            'clientsCount' => User::where('role', User::ROLE_CLIENT)->get()->count(),
            'brigadirsCount' => User::where('role', User::ROLE_BRIGADIR)->get()->count(),
            'transportsCount' => Transport::all()->count()
        ];
    }
}