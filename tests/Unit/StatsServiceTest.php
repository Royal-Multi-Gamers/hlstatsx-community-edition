<?php

use App\Services\StatsService;
use Illuminate\Support\Facades\Cache;

test('global stats returns expected keys', function () {
    $service = app(StatsService::class);
    $stats   = $service->getGlobalStats();

    expect($stats)->toBeArray()
        ->and($stats)->toHaveKeys(['players', 'clans', 'games', 'servers', 'kills']);
});

test('top players returns paginator', function () {
    $service = app(StatsService::class);
    $players = $service->getTopPlayers('');

    expect($players)->toBeInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class);
});

test('global stats are cached', function () {
    Cache::forget('stats.global');

    $service = app(StatsService::class);
    $service->getGlobalStats();

    expect(Cache::has('stats.global'))->toBeTrue();
});
