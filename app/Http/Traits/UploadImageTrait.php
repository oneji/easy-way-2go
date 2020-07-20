<?php

namespace App\Http\Traits;

trait UploadImageTrait
{
    /**
     * A simple method to upload images.
     * 
     * @param array $images
     * @param array $folder
     */
    public function uploadImage($image, $folder)
    {
        $filePath = $image->store($folder, ['disk' => 'public']);

        return $filePath;
    }
}