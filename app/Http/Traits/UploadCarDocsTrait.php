<?php

namespace App\Http\Traits;
use App\CarDoc;
use App\Transport;

trait UploadCarDocsTrait
{
    /**
     * Simple method to upload car docs
     * 
     * @param array $files
     * @param string $folder
     * @param string $docType
     */
    public function uploadDocs($files, $folder, $docType)
    {
        $docs = [];

        foreach ($files as $file) {
            $doc = $file->store($folder, ['disk' => 'public']);

            $docs[] = new CarDoc([
                'file_path' => $doc,
                'doc_type' => $docType
            ]);
        }

        return $docs;
    }
}