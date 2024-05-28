<?php

namespace App\Http\Controllers;

use App\Services\Movies\MovieAggregatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    protected MovieAggregatorService $movieAggregatorService;

    public function __construct(MovieAggregatorService $movieAggregatorService)
    {
        $this->movieAggregatorService = $movieAggregatorService;
    }
    public function getTitles(Request $request): JsonResponse
    {
        try {
            $titles = $this->movieAggregatorService->getAggregatedTitles();
            return response()->json($titles);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failure']);
        }
    }
}
