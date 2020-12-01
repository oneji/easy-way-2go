<?php

namespace App\Http\Services;

use App\BankCard;
use App\Http\JsonRequests\StoreBankCardRequest;

class BankCardService
{
    /**
     * Get all user's bank cards
     * 
     * @return collection
     */
    public function all()
    {
        $client = auth('client')->user();
        $driver = auth('driver')->user();
        $brigadir = auth('brigadir')->user();

        if($client) return $client->bank_cards;
        if($driver) return $driver->bank_cards;
        if($brigadir) return $brigadir->bank_cards;
    }

    /**
     * Store a newly created bank card
     * 
     * @param \App\Http\JsonRequests\StoreBankCardRequest
     */
    public function store(StoreBankCardRequest $request)
    {
        $client = auth('client')->user();
        $driver = auth('driver')->user();
        $brigadir = auth('brigadir')->user();

        $card = new BankCard($request->all());

        if($client) {
            $card->cardable_id = $client->id;
            $card->cardable_type = 'App\Client';
        };
        if($driver) { 
            $card->cardable_id = $driver->id;
            $card->cardable_type = 'App\Driver';
        }
        if($brigadir) {
            $card->cardable_id = $brigadir->id;
            $card->cardable_type = 'App\Brigadir';
        }

        $card->save();
    }
}