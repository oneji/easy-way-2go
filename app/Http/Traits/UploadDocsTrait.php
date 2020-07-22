<?php

namespace App\Http\Traits;

trait UploadDocsTrait
{
    /**
     * A simple method to upload user documents.
     * 
     * @param array $docs
     * @param array $folder
     */
    public function uploadDocs($files, $folder)
    {
        $docs = [];
        foreach ($files as $file) {
            $docs[] = $file->store($folder, ['disk' => 'public']);
        }

        return $docs;
    }
}