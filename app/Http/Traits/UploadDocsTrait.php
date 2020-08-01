<?php

namespace App\Http\Traits;

trait UploadDocsTrait
{
    /**
     * A simple method to upload user documents.
     * 
     * @param array $docs
     * @param array $folder
     * @param string $docType
     */
    public function uploadDocs($files, $folder, $docType = null)
    {
        $docs = [];
        foreach ($files as $file) {
            if($docType !== null) {
                $docs[] = [
                    'id' => uniqid(),
                    'file' => $file->store($folder, ['disk' => 'public']),
                    'type' => $docType
                ];
            } else {
                $docs[] = [
                    'id' => uniqid(),
                    'file' => $file->store($folder, ['disk' => 'public']),
                ];
            }
        }

        return $docs;
    }
}