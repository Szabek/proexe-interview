<?php

namespace App\Http\Controllers;

use App\Services\Movies\MovieAggregator;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{

    protected MovieAggregator $movieAggregator;

    public function __construct(MovieAggregator $movieAggregator)
    {
        $this->movieAggregator = $movieAggregator;
    }

    public function getTitles(): JsonResponse
    {
        try {
            $titles = $this->movieAggregator->getAggregatedTitles();
            return response()->json($titles);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
