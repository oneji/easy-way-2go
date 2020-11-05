<?php

namespace App\Http\Services;

use App\Http\JsonRequests\StoreBaRequest;
use App\Http\Services\UploadFileService;
use App\BaMainDriverData;
use App\BaFirmOwnerData;
use App\BaRequest;
use Carbon\Carbon;

class BaRequestService
{
    /**
     * Get all bussiness account requests
     * 
     * @return collection
     */
    public function all()
    {
        return BaRequest::all();
    }
    
    /**
     * Get all bussiness account requests paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return BaRequest::paginate(10);
    }

    /**
     * Get a specific bussiness account request by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $baRequest = BaRequest::find($id);
        
        if($baRequest->type === 'firm_owner') {
            $baRequest->data = BaFirmOwnerData::where('ba_request_id', $id)->first();
        } else {
            $baRequest->data = BaMainDriverData::where('ba_request_id', $id)->first();
        }

        return $baRequest;
    }

    /**
     * Store a newly created bussiness account request
     * 
     * @param App\Http\JsonRequests\StoreBaRequest $request
     */
    public function store(StoreBaRequest $request)
    {
        $baRequest = new BaRequest();
        $baRequest->type = $request->type;
        $baRequest->save();

        if($request->type === 'firm_owner') {
            $this->storeFirmOwnerData($request->except('type'), $baRequest->id);
        } else if($request->type === 'head_driver') {
            $this->storeHeadDriverData($request->except('type'), $baRequest->id);
        }
    }

    /**
     * Store firm owner data
     * 
     * @param array $firmOwnerData
     */
    private function storeFirmOwnerData($data, $baRequestId)
    {
        $firmOwnerData = new BaFirmOwnerData($data);
        $firmOwnerData->birthday = Carbon::parse($data['birthday']);
        $firmOwnerData->ba_request_id = $baRequestId;

        if(isset($data['passport_photo'])) {
            $firmOwnerData->passport_photo = UploadFileService::uploadMultiple($data['passport_photo'], 'ba_requests');
        }

        $firmOwnerData->save();
    }

    /**
     * Store head driver data
     * 
     * @param array $mainDriverData
     */
    private function storeHeadDriverData($data, $baRequestId)
    {
        $mainDriverData = new BaMainDriverData($data);
        $mainDriverData->birthday = Carbon::parse($data['birthday']);
        $mainDriverData->dl_issued_at = Carbon::parse($data['dl_issued_at']);
        $mainDriverData->dl_expires_at = Carbon::parse($data['dl_expires_at']);
        $mainDriverData->grades_expire_at = Carbon::parse($data['grades_expire_at']);
        $mainDriverData->ba_request_id = $baRequestId;

        if(isset($data['driving_license_photos'])) {
            $mainDriverData->driving_license_photos = UploadFileService::uploadMultiple($data['driving_license_photos'], 'ba_requests');
        }

        if(isset($data['passport_photos'])) {
            $mainDriverData->passport_photos = UploadFileService::uploadMultiple($data['passport_photos'], 'ba_requests');
        }

        $mainDriverData->save();
    }
}