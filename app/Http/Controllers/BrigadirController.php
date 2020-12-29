<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BrigadirService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Country;

class BrigadirController extends Controller
{
    private $brigadirService;

    /**
     * BrigadirController constructor
     * 
     * @param \App\Http\Services\BrigadirService $brigadirService
     */
    public function __construct(BrigadirService $brigadirService)
    {
        $this->brigadirService = $brigadirService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brigadirs = $this->brigadirService->all();

        return view('brigadirs.index', [
            'brigadirs' => $brigadirs
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

        return view('brigadirs.create', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $data = $this->brigadirService->store($request);

        $request->session()->flash('success', 'Бригадир успешно создан.');

        return redirect()->route('admin.brigadirs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brigadir = $this->brigadirService->getById($id);

        if(!$brigadir) abort(404);

        return view('brigadirs.show', [
            'brigadir' => $brigadir
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
        $countries = Country::all();
        $brigadir = $this->brigadirService->getById($id);

        if(!$brigadir) abort(404);        

        return view('brigadirs.edit', [
            'brigadir' => $brigadir,
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->brigadirService->update($request, $id);

        $request->session()->flash('success', 'Информация успешно обновлена.');

        return back();
    }
}
