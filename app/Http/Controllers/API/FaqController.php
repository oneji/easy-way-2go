<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\FaqService;

class FaqController extends Controller
{
    protected $faqService;

    /**
     * FaqController constructor
     * 
     * @param \App\Http\Services\FaqService $faqService
     */
    public function __construct(FaqService $faqService) {
        $this->faqService = $faqService;
    }

    
    /**
     * Get all faqs
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $data = $this->faqService->all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get faq by id
     * 
     * @param   int $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getById($id)
    {
        $data = $this->faqService->getById($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
