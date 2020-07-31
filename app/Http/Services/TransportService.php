<?php

namespace App\Http\Services;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransportRequest;
use App\Http\Requests\UpdateTransportRequest;
use App\Http\Traits\UploadDocsTrait;
use App\Transport;
use App\CarImage;
use Carbon\Carbon;

class TransportService
{
    use UploadDocsTrait;

    /**
     * Show a listing of transportation
     * 
     * @return collection
     */
    public function all()
    {
        return Transport::with('car_images')
            ->join('countries', 'countries.id', '=', 'transports.register_country')
            ->join('car_brands', 'car_brands.id', '=', 'transports.car_brand_id')
            ->join('car_models', 'car_models.id', '=', 'transports.car_model_id')
            ->select('transports.*', 'countries.name as register_country_name', 'car_brands.name as car_brand_name', 'car_models.name as car_model_name')
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
        $transport->register_city = $request->register_city;
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

        // $this->storeDocs($transport, $request);
    }

    /**
     * Get the transport by id.
     * 
     * @param   int $id
     * @return  \App\Transport
     */
    public function getById($id)
    {
        return Transport::with('car_images')->where('id', $id)->first();
    }

    /**
     * Store transport's doc files
     * @param
     */
    private function storeDocs(Transport $transport, Request $request)
    {
        $car_passport = null;
        $teh_osmotr = null;
        $insurance = null;
        $people_license = null;
        $car_photos = null;
        $trailer_photos = null;

        if($request->hasFile('car_passport')) {
            $car_passport = $this->uploadDocs($request->car_passport, 'car_docs/passport');
        }
        
        if($request->hasFile('teh_osmotr')) {
            $teh_osmotr = $this->uploadDocs($request->teh_osmotr, 'car_docs/teh_osmotr');
        }

        if($request->hasFile('insurance')) {
            $insurance = $this->uploadDocs($request->insurance, 'car_docs/insurance');
        }

        if($request->hasFile('people_license')) {
            $people_license = $this->uploadDocs($request->people_license, 'car_docs/people_license');
        }

        if($request->hasFile('car_photos')) {
            $car_photos = $this->uploadDocs($request->car_photos, 'car_docs/car_photos');
        }

        if($request->hasFile('trailer_photos')) {
            $trailer_photos = $this->uploadDocs($request->trailer_photos, 'car_docs/trailer_photos');
        }

        $transport->car_images()->save(new CarImage([
            'car_passport' => $car_passport,
            'teh_osmotr' => $teh_osmotr,
            'insurance' => $insurance,
            'people_license' => $people_license,
            'car_photos' => $car_photos,
            'trailer_photos' => $trailer_photos,
        ]));
    }
}