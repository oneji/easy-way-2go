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
        return Transport::with(['car_docs', 'users', 'car_brand', 'car_model'])
            ->join('countries', 'countries.id', '=', 'transports.register_country')
            ->select('transports.*', 'countries.name as register_country_name')
            ->paginate(8);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transport = new Transport($request->all());
        
        foreach ($request->translations as $code => $value) {
            $transport->setTranslation('register_city', $code, $value['register_city']);
        }

        // Save parsed date fields
        $transport->teh_osmotr_date_from = Carbon::parse($request->teh_osmotr_date_from);
        $transport->teh_osmotr_date_to = Carbon::parse($request->teh_osmotr_date_to);
        $transport->insurance_date_from = Carbon::parse($request->insurance_date_from);
        $transport->insurance_date_to = Carbon::parse($request->insurance_date_to);
        $transport->save();

        // Docs
        $this->storeDocs($transport, $request);
    }

    /**
     * Update a specific transport.
     * 
     * @param   \App\Http\Requests\UpdateTransportRequest $request
     * @param   int $id
     */
    public function update(UpdateTransportRequest $request, $id)
    {
        $transport = Transport::find($id);
        $transport->registered_on = $request->registered_on;
        $transport->register_country = $request->register_country;
        
        foreach ($request->translations as $code => $value) {
            $transport->setTranslation('register_city', $code, $value['register_city']);
        }

        $transport->car_number = $request->car_number;
        $transport->car_brand_id = $request->car_brand_id;
        $transport->car_model_id = $request->car_model_id;
         // Save parsed date fields
        $transport->teh_osmotr_date_from = Carbon::parse($request->teh_osmotr_date_from);
        $transport->teh_osmotr_date_to = Carbon::parse($request->teh_osmotr_date_to);
        $transport->insurance_date_from = Carbon::parse($request->insurance_date_from);
        $transport->insurance_date_to = Carbon::parse($request->insurance_date_to);
        // *** 
        $transport->has_cmr = $request->has_cmr;
        $transport->passengers_seats = $request->passengers_seats; 
        $transport->cubo_metres_available = $request->cubo_metres_available; 
        $transport->kilos_available = $request->kilos_available; 
        $transport->ok_for_move = $request->ok_for_move; 
        $transport->can_pull_trailer = $request->can_pull_trailer; 
        $transport->has_trailer = $request->has_trailer; 
        $transport->pallet_transportation = $request->pallet_transportation; 
        $transport->air_conditioner = $request->air_conditioner; 
        $transport->wifi = $request->wifi; 
        $transport->tv_video = $request->tv_video; 
        $transport->disabled_people_seats = $request->disabled_people_seats;
        $transport->save();

        $this->storeDocs($transport, $request);
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
    private function storeDocs(Transport $transport, Request $request)
    {
        $docs = [];
        if($request->hasFile('car_passport')) {
            $docs = array_merge($docs, $this->uploadDocs($request->car_passport, 'car_docs/passport', Transport::DOC_TYPE_PASSPORT));
        }
        
        if($request->hasFile('teh_osmotr')) {
            $docs = array_merge($docs, $this->uploadDocs($request->teh_osmotr, 'car_docs/teh_osmotr', Transport::DOC_TYPE_TEH_OSMOTR));
        }

        if($request->hasFile('insurance')) {
            $docs = array_merge($docs, $this->uploadDocs($request->insurance, 'car_docs/insurance', Transport::DOC_TYPE_INSURANCE));
        }

        if($request->hasFile('people_license')) {
            $docs = array_merge($docs, $this->uploadDocs($request->people_license, 'car_docs/people_license', Transport::DOC_TYPE_PEOPLE_LICENSE));
        }

        if($request->hasFile('car_photos')) {
            $docs = array_merge($docs, $this->uploadDocs($request->car_photos, 'car_docs/car_photos', Transport::DOC_TYPE_CAR_PHOTOS));
        }

        if($request->hasFile('trailer_photos')) {
            $docs = array_merge($docs, $this->uploadDocs($request->trailer_photos, 'car_docs/trailer_photos', Transport::DOC_TYPE_TRAILER_PHOTOS));
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
     * @param \App\Http\Requests\BindDriverRequest $request
     */
    public function bindDriver(BindDriverRequest $request)
    {
        $transport = Transport::find($request->transport_id);
        
        // Check if the drivers is already bound to the transport
        if(!$transport->users->contains($request->driver_id)) {
            // Check if the transport has less than available drivers bound
            if(count($transport->users) < Transport::DRIVER_MAX_COUNT) {
                $transport->users()->attach($request->driver_id);
            }
        }
    }
}