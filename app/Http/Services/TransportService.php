<?php

namespace App\Http\Services;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransportRequest;
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
            ->join('car_brands', 'car_brands.id', '=', 'transports.car_brand_id')
            ->join('car_models', 'car_models.id', '=', 'transports.car_model_id')
            ->select('transports.*', 'car_brands.name as car_brand_name', 'car_models.name as car_model_name')
            ->paginate(10);
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
        $transport->year = Carbon::parse($request->year);
        $transport->teh_osmotr_date_from = Carbon::parse($request->teh_osmotr_date_from);
        $transport->teh_osmotr_date_to = Carbon::parse($request->teh_osmotr_date_to);
        $transport->insurance_date_from = Carbon::parse($request->insurance_date_from);
        $transport->insurance_date_to = Carbon::parse($request->insurance_date_to);
        $transport->save();

        // Docs
        $this->storeDocs($transport, $request);
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
            'car_passport' => $car_passport === null ? null : json_encode($car_passport),
            'teh_osmotr' => $teh_osmotr === null ? null : json_encode($teh_osmotr),
            'insurance' => $insurance === null ? null : json_encode($insurance),
            'people_license' => $people_license === null ? null : json_encode($people_license),
            'car_photos' => $car_photos === null ? null : json_encode($car_photos),
            'trailer_photos' => $trailer_photos === null ? null : json_encode($trailer_photos),
        ]));
    }
}