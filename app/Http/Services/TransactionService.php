<?php

namespace App\Http\Services;

use App\Transaction;

class TransactionService
{
    /**
     * Store a newly created transaction
     * 
     * @param array $data
     */
    public function store($data)
    {
        $transaction = new Transaction();
        $transaction->payment_method_id = $data['payment_method_id'];
        $transaction->order_id = $data['order_id'];
        $transaction->amount = $data['amount'];
        $transaction->type = $data['type'];
        $transaction->date = $data['date'];
        $transaction->save();
    }
}