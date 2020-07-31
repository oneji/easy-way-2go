<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Services\DriverService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\DrivingExperience;
use App\User;
use App\Country;

class DriverController extends Controller
{
    private $driverService;

    /**
     * DriverController constructor.
     * 
     * @param \App\Http\Services\DriverService $driverService
     */
    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = $this->driverService->all();

        // return $drivers;

        return view('drivers.index', [ 
            'drivers' => $drivers,
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
        $deList = DrivingExperience::all();

        return view('drivers.create', [
            'countries' => $countries,
            'deList' => $deList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $response = $this->driverService->store($request);

        $request->session()->flash('success', 'Водитель успешно создан!');

        return redirect()->route('admin.drivers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = $this->driverService->getById($id);

        if(!$driver) abort(404);
        
        return view('drivers.show', [
            'driver' => $driver
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = $this->driverService->getById($id);
        $countries = Country::all();
        $deList = DrivingExperience::all();

        // return $driver;

        if(!$driver) abort(404);        

        return view('drivers.edit', [
            'driver' => $driver,
            'countries' => $countries,
            'deList' => $deList
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->driverService->update($request, $id);

        $request->session()->flash('success', 'Информация успешно обновлена!');

        return back();
    }

    /**
     * Delete driver's document
     * 
     * @param   int $driverId
     * @param   int $docId
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroyDoc($driverId, $docId)
    {
        $this->driverService->destroyDoc($driverId, $docId);

        Session::flash('success', 'Документ успешно удалён.');

        return redirect()->back();
    }
}
