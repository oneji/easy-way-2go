<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTransportRequest;
use App\Http\Requests\UpdateTransportRequest;
use App\Http\Requests\BindDriverRequest;
use App\Http\Traits\UploadCarDocsTrait;
use App\Transport;
use App\CarDoc;
use Carbon\Carbon;

class TransportService
{
    use UploadCarDocsTrait;

    /**
     * Show a listing of transportation
     * 
     * @return collection
     */
    public function all()
    {
        return Transport::with(['car_docs', 'drivers', 'car_brand', 'car_model'])
            ->join('countries', 'countries.id', '=', 'transports.register_country')
            ->select('transports.*', 'countries.name as register_country_name')
            ->paginate(8);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $data
     * @return \Illuminate\Http\Response
     */
    public function store($data)
    {
        $transport = new Transport($data);

        // Save parsed date fields
        $transport->teh_osmotr_date_from = Carbon::parse($data['teh_osmotr_date_from']);
        $transport->teh_osmotr_date_to = Carbon::parse($data['teh_osmotr_date_to']);
        $transport->insurance_date_from = Carbon::parse($data['insurance_date_from']);
        $transport->insurance_date_to = Carbon::parse($data['insurance_date_to']);
        $transport->save();

        // Docs
        $this->storeDocs($transport, $data);

        return $transport;
    }

    /**
     * Update a specific transport.
     * 
     * @param   object $data
     * @param   int $id
     */
    public function update($data, $id)
    {
        $transport = Transport::find($id);
        $transport->registered_on = $data['registered_on'];
        $transport->register_country = $data['register_country'];
        $transport->register_city = $data['register_city'];
        $transport->car_number = $data['car_number'];
        $transport->car_brand_id = $data['car_brand_id'];
        $transport->car_model_id = $data['car_model_id'];
         // Save parsed date fields
        $transport->teh_osmotr_date_from = Carbon::parse($data['teh_osmotr_date_from']);
        $transport->teh_osmotr_date_to = Carbon::parse($data['teh_osmotr_date_to']);
        $transport->insurance_date_from = Carbon::parse($data['insurance_date_from']);
        $transport->insurance_date_to = Carbon::parse($data['insurance_date_to']);
        // *** 
        $transport->has_cmr = $data['has_cmr'];
        $transport->passengers_seats = $data['passengers_seats']; 
        $transport->cubo_metres_available = $data['cubo_metres_available']; 
        $transport->kilos_available = $data['kilos_available']; 
        $transport->ok_for_move = $data['ok_for_move']; 
        $transport->can_pull_trailer = $data['can_pull_trailer']; 
        $transport->has_trailer = $data['has_trailer']; 
        $transport->pallet_transportation = $data['pallet_transportation']; 
        $transport->air_conditioner = $data['air_conditioner']; 
        $transport->wifi = $data['wifi']; 
        $transport->tv_video = $data['tv_video']; 
        $transport->disabled_people_seats = $data['disabled_people_seats'];
        $transport->save();

        $this->storeDocs($transport, $data);

        return $transport;
    }

    /**
     * Get the transport by id.
     * 
     * @param   int $id
     * @return  \App\Transport
     */
    public function getById($id)
    {
        return Transport::with('car_docs')->where('id', $id)->first();
    }

    /**
     * Store transport's doc files
     * @param
     */
    private function storeDocs(Transport $transport, $data)
    {
        $docs = [];
        if(isset($data['car_passport'])) {
            $docs = array_merge($docs, $this->uploadDocs($data['car_passport'], 'car_docs/passport', Transport::DOC_TYPE_PASSPORT));
        }
        
        if(isset($data['teh_osmotr'])) {
            $docs = array_merge($docs, $this->uploadDocs($data['teh_osmotr'], 'car_docs/teh_osmotr', Transport::DOC_TYPE_TEH_OSMOTR));
        }

        if(isset($data['insurance'])) {
            $docs = array_merge($docs, $this->uploadDocs($data['insurance'], 'car_docs/insurance', Transport::DOC_TYPE_INSURANCE));
        }

        if(isset($data['people_license'])) {
            $docs = array_merge($docs, $this->uploadDocs($data['people_license'], 'car_docs/people_license', Transport::DOC_TYPE_PEOPLE_LICENSE));
        }

        if(isset($data['car_photos'])) {
            $docs = array_merge($docs, $this->uploadDocs($data['car_photos'], 'car_docs/car_photos', Transport::DOC_TYPE_CAR_PHOTOS));
        }

        if(isset($data['trailer_photos'])) {
            $docs = array_merge($docs, $this->uploadDocs($data['trailer_photos'], 'car_docs/trailer_photos', Transport::DOC_TYPE_TRAILER_PHOTOS));
        }

        $transport->car_docs()->saveMany($docs);
    }

    /**
     * Destroy transport's doc
     * 
     * @param   int $id
     */
    public function destroyDoc($id)
    {
        $doc = CarDoc::find($id);

        if($doc) {
            // Delete the doc from the storage
            Storage::disk('public')->delete($doc->file_path);
            // Delete the doc from the db
            $doc->delete();
        }
    }

    /**
     * Bind the driver to the transport
     * 
     * @param int $transportId
     * @param int $driverId
     */
    public function bindDriver($transportId, $driverId)
    {
        $transport = Transport::find($transportId);
        
        // Check if the drivers is already bound to the transport
        if(!$transport->drivers->contains($driverId)) {
            // Check if the transport has less than available drivers bound
            if(count($transport->drivers) < Transport::DRIVER_MAX_COUNT) {
                $transport->drivers()->attach($driverId);
            }
        }
    }
}