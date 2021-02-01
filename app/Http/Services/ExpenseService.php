<?php

namespace App\Http\Services;

use App\Expense;
use App\Photo;

class ExpenseService
{
    /**
     * Store a newly created expenses
     * 
     * @param array $expenses
     * @param int $tripId
     */
    public function store($expenses, $trip)
    {
        foreach ($expenses as $data) {
            $expense = new Expense($data);
            $expense->type = $trip->type;
            $expense->trip_id = $trip->id;
            $expense->save();

            if(isset($data['photos'])) {
                $photos = [];
                foreach ($data['photos'] as $photo) {
                    $photos[] = new Photo([
                        'path' => UploadFileService::upload($photo, 'expenses')
                    ]);
                }

                $expense->photos()->saveMany($photos);
            }
        }
    }
}