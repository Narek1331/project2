<?php

namespace App\Http\Controllers\Api;

use App\Services\RegionService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    protected RegionService $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    public function index(): JsonResponse
    {
        $regions = $this->regionService->getAllTree();

        return response()->json([
            'success' => true,
            'data' => $regions,
        ]);
    }
}
