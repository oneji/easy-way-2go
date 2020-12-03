<?php

namespace App\Http\Services;

use App\MovingCargo;
use App\MovingData;
use App\Photo;

class MovingDataService
{
    /**
     * Store newly created moving data
     * 
     * @param array $data
     */
    public static function store($data)
    {
        $movingData = new MovingData($data);
        $movingData->save();

        foreach ($data['cargos'] as $cargo) {
            // Fill moving cargos array with new cargo objects and save
            $movingCargo = new MovingCargo($cargo);
            $movingCargo->moving_data_id = $movingData->id;
            $movingCargo->save();

            if(isset($cargo['photos'])) {
                // Upload cargo images
                $movingCargoPhotos = [];
                foreach ($cargo['photos'] as $photo) {
                    $movingCargoPhotos[] = new Photo([
                        'path' => UploadFileService::upload($photo, 'moving_cargo_photos')
                    ]);
                }
    
                // Bult insert cargo photos
                $movingCargo->photos()->saveMany($movingCargoPhotos);
            }
        }
    }
}