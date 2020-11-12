<?php

namespace App\Http\Services;

use App\Http\Services\UploadFileService;
use App\Package;
use App\Order;

class PackageService
{
    /**
     * Attach same packages to the order
     * 
     * @param array $packagesData
     * @param int $orderId
     * @param string $type
     */
    public static function attachSameToOrder($packagesData, $count, $orderId)
    {
        $packagesToInsert = [];
        for ($i = 0; $i < $count; $i++) { 
            $packagesToInsert[] = [
                'weight' => $packagesData['weight'],
                'length' => $packagesData['length'],
                'width' => $packagesData['width'],
                'height' => $packagesData['height'],
                'photos' => isset($packagesData['photos']) ? UploadFileService::uploadMultiple($packagesData['photos'], 'packages') : null,
                'order_id' => $orderId,
            ];
        }

        Package::insert($packagesToInsert);
    }
    
    /**
     * Attach different packages to the order
     * 
     * @param array $packages
     * @param int $orderId
     * @param string $type
     */
    public static function attachDifferentToOrder($packages, $orderId)
    {
        $packagesToInsert = [];
        foreach ($packages as $package) {
            $packagesToInsert[] = [
                'weight' => $package['weight'],
                'length' => $package['length'],
                'width' => $package['width'],
                'height' => $package['height'],
                'photos' => isset($package['photos']) ? UploadFileService::uploadMultiple($package['photos'], 'packages') : null,
                'order_id' => $orderId,
            ];
        }

        Package::insert($packagesToInsert);
    }
}