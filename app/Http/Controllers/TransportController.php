<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Services\TransportService;
use App\Http\Services\DriverService;
use App\Http\Requests\StoreTransportRequest;
use App\Http\Requests\UpdateTransportRequest;
use App\Http\Requests\BindDriverRequest;
use App\Country;
use App\CarBrand;
use App\CarModel;

class TransportController extends Controller
{
    private $transportService;
    private $driverService;

    /**
     * TransportController constructor.
     * 
     * @param \App\Http\Services\TransportService $transportService
     * @param \App\Http\Services\DriverService $driverService
     */
    public function __construct(TransportService $transportService, DriverService $driverService)
    {
        $this->transportService = $transportService;
        $this->driverService = $driverService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tranport = $this->transportService->all();
        $drivers = $this->driverService->all();

        return view('transport.index', [
            'transport' => $tranport,
            'drivers' => $drivers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $carBrands = CarBrand::all();
        $carModels = CarModel::all();

        return view('transport.create', [
            'countries' => $countries,
            'carBrands' => $carBrands,
            'carModels' => $carModels
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransportRequest $request)
    {
        $this->transportService->store($request);
        
        $request->session()->flash('success', 'Транспортное средство успешно добавлено.');

        return redirect()->route('admin.transport.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tranport = $this->transportService->getById($id);
        $countries = Country::all();
        $carBrands = CarBrand::all();
        $carModels = CarModel::all();

        // return $tranport;

        return view('transport.edit', [
            'transport' => $tranport,
            'countries' => $countries,
            'carBrands' => $carBrands,
            'carModels' => $carModels
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransportRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransportRequest $request, $id)
    {
        $this->transportService->update($request, $id);

        $request->session()->flash('success', 'Транспортное средство успешно обновлено.');

        return redirect()->back();
    }

    /**
     * Destroy transport's doc
     * 
     * @param   int $tranportId
     * @param   int $docId
     * @param   string $docType
     * @return  \Illuminate\Http\Response
     */
    public function destroyDoc($id)
    {
        $this->transportService->destroyDoc($id);

        Session::flash('success', 'Документ успешно удален.');

        return redirect()->back();
    }

    /**
     * Bind the user to the transport
     * 
     * @param   \App\Http\Requests\BindDriverRequest $request
     * @param   int $tranportId
     */
    public function bindDriver(BindDriverRequest $request)
    {
        $this->transportService->bindDriver($request);

        $request->session()->flash('success', 'Водитель успешно привязан.');

        return redirect()->back();
    }
}
