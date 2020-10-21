<?php

namespace App\Http\Services;

use App\Language;
use App\Http\Requests\StoreLanguageRequest;

class LanguageService
{
    /**
     * Show a listing of languages.
     * 
     * @return collection
     */
    public function all()
    {
        return Language::paginate(10);
    }

    /**
     * Get a specific language item by id.
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return Language::find($id);
        
    }

    /**
     * Store a newly created language.
     * 
     * @param   \App\Http\Requests\StoreLanguageRequest $request
     * @return  void
     */
    public function store(StoreLanguageRequest $request)
    {
        $lang = new Language();
        
        foreach ($request->translations as $code => $item) {
            $lang->setTranslation('name', $code, $item['name']);
        }

        $lang->code = $request->code;
        $lang->save();

        $request->session()->flash('success', trans('pages.languages.successAddedAlert'));
    }

    /**
     * Update an existing language item.
     * 
     * @param \App\Http\Requests\StoreLanguageRequest $request
     * @return void
     */
    public function update(StoreLanguageRequest $request, $id)
    {
        $lang = Language::find($id);
        
        foreach ($request->translations as $code => $item) {
            $lang->setTranslation('name', $code, $item['name']);
        }
        $lang->code = $request->code;
        $lang->save();

        $request->session()->flash('success', trans('pages.languages.successEditedAlert'));
    }
}