<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\LanguageService;
use App\Http\Requests\StoreLanguageRequest;

class LanguageController extends Controller
{
    private $langService;

    /**
     * LanguageController constructor
     * 
     * @param \App\Http\Services\LanguageService $langService
     */
    public function __construct(LanguageService $langService)
    {
        $this->langService = $langService;
    }

    /**
     * Show a listing of resources
     * 
     * @return void
     */
    public function index()
    {
        $langs = $this->langService->all();

        return view('languages.index', [
            'langs' => $langs
        ]);
    }

    /**
     * Get a specific driving experience item by id.
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $lang = $this->langService->getById($id);

        return response()->json($lang);
    }

    /**
     * Store a newly created item
     * 
     * @param   \App\Htt\Requests\StoreLanguageRequest $request
     * @return  void
     */
    public function store(StoreLanguageRequest $request)
    {
        $this->langService->store($request);

        return redirect()->back();
    }

    /**
     * Update an existing driving experience item.
     * 
     * @param \App\Http\Requests\StoreLanguageRequest $request
     * @return void
     */
    public function update(StoreLanguageRequest $request, $id)
    {
        $this->langService->update($request, $id);

        return redirect()->back();
    }
}
