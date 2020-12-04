<?php

namespace App\Http\Services;

use App\Faq;
use App\Http\Requests\FaqRequest;

class FaqService
{
    /**
     * Get all faqs
     * 
     * @return collection
     */
    public function all()
    {
        return Faq::all();
    }
    
    /**
     * Get all faqs paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return Faq::paginate(10);
    }

    /**
     * Get by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return Faq::find($id);
    }

    /**
     * Store a newly created faq
     * 
     * @param \App\Http\Requests\FaqRequest $request
     */
    public function store(FaqRequest $request)
    {
        $faq = new Faq($request->all());
        $faq->save();
    }

    /**
     * Update an existing faq
     * 
     * @param \App\Http\Requests\FaqRequest $request
     * @param int $id
     */
    public function update(FaqRequest $request, $id)
    {
        $faq = Faq::find($id);
        $faq->title = $request->title;
        $faq->description = $request->description;
        $faq->full_description = $request->full_description;
        $faq->save();
    }

    /**
     * Delete faq
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $faq = Faq::find($id);
        $faq->deleted = 1;
        $faq->save();
    }
}