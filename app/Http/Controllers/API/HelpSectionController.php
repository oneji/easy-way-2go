<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\HelpSectionService;

class HelpSectionController extends Controller
{
    protected $sectionService;

    /**
     * FaqController constructor
     * 
     * @param \App\Http\Services\HelpSectionService $sectionService
     */
    public function __construct(HelpSectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }
    
    /**
     * Get all help
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $data = $this->sectionService->all();

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
        $data = $this->sectionService->getById($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
