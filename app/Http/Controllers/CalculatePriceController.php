<?php

namespace App\Http\Controllers;

use App\Http\Services\CalculatePriceService;

/**
 * CalculatePriceController
 */
class CalculatePriceController extends Controller
{
    public function __construct(CalculatePriceService $calculatePriceService)
    {
        $this->calculatePriceService = $calculatePriceService;
    }

    /**
     * store
     *
     */
    public function store()
    {
        $this->calculatePriceService->getAll();
    }
}
