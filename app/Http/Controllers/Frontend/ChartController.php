<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\StatsService;
use Illuminate\Http\JsonResponse;

class ChartController extends Controller
{
    public function __construct(private StatsService $stats) {}

    public function activity(int $serverId): JsonResponse
    {
        $data = $this->stats->getActivityChart($serverId);
        return response()->json($data);
    }
}
