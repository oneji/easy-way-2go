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
    public function store($expenses, $tripId)
    {
        foreach ($expenses as $data) {
            $expense = new Expense($data);
            $expense->trip_id = $tripId;
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