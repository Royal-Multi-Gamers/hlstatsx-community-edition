<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\StatsService;
use Illuminate\Http\JsonResponse;

class LiveFeedController extends Controller
{
    public function __construct(private StatsService $stats) {}

    public function index(): JsonResponse
    {
        $stats = $this->stats->getGlobalStats();
        return response()->json($stats);
    }
}
