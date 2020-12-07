<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Http\Services\FaqService;

class FaqController extends Controller
{
    protected $faqService;

    /**
     * FaqController constructor
     * 
     * @param \App\Http\Services\FaqService $faqService
     */
    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    /**
     * Show a listing of all faq
     * 
     * @return \Illumminate\Http\Response
     */
    public function index()
    {
        $data = $this->faqService->getPaginated();

        return view('faq.index', [
            'data' => $data
        ]);
    }

    /**
     * Show create faq form
     */
    public function create()
    {
        return view('faq.create');
    }

    /**
     * Store a newly created faq
     * 
     * @param \App\Http\Requests\FaqRequest $request
     */
    public function store(FaqRequest $request)
    {
        $this->faqService->store($request);

        return redirect()->back();
    }

    /**
     * Show an edit form
     * 
     * @param int $id
     */
    public function edit($id)
    {
        $item = $this->faqService->getById($id);

        return view('faq.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update an existing faq
     * 
     * @param \App\Http\Requests\FaqRequest $request
     * @param int $id
     */
    public function update(FaqRequest $request, $id)
    {
        $this->faqService->update($request, $id);

        return redirect()->back();
    }

    /**
     * Delete faq
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $this->faqService->delete($id);

        return redirect()->back();
    }
}
