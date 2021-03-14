<?php

namespace App\Http\Controllers;

use App\Http\Services\StonePermutationService;

/**
 * PermutationController
 */
class PermutationController extends Controller
{
    public function __construct(StonePermutationService $stonePermutationService)
    {
        $this->stonePermutationService = $stonePermutationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->stonePermutationService->create();
    }
}
