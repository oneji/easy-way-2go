<?php

namespace App\Http\Services;

class UploadFileService
{
    /**
     * Simple method to upload file
     * 
     * @param   file $file
     * @param   string $folder
     * @return  string
     */
    public static function upload($file, $folder)
    {
        return $file->store($folder, ['disk' => 'public']);
    }

    /**
     * Simple method to upload multiple files
     * 
     * @param   array $files
     * @param   string $folder
     * @return  array
     */
    public static function uploadMultiple($files, $folder)
    {
        $filesArray = [];
        foreach ($files as $file) {
            $filesArray[] = [
                'id' => uniqid(),
                'file' => $file->store($folder, ['disk' => 'public']),
            ];
        }

        return $filesArray;
    }
}