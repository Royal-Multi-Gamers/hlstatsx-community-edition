<?php

use App\Services\ThemeService;
use Illuminate\Support\Facades\Cache;

test('theme service returns active theme', function () {
    $service = app(ThemeService::class);
    $theme   = $service->getActive();

    expect($theme)->toBeArray()
        ->and($theme)->toHaveKey('meta')
        ->and($theme)->toHaveKey('colors');
});

test('theme service returns all themes', function () {
    $service = app(ThemeService::class);
    $themes  = $service->getAll();

    expect($themes)->toBeArray()
        ->and(count($themes))->toBeGreaterThanOrEqual(6);
});

test('css variables are generated from theme', function () {
    $service = app(ThemeService::class);
    $theme   = $service->getActive();
    $css     = $service->getCssVariables($theme);

    expect($css)->toBeString()
        ->and($css)->toContain('--');
});

test('setting active theme updates cache', function () {
    $service = app(ThemeService::class);
    Cache::forget('theme.active');

    $service->setActive('hlstatsx-dark');
    $theme = $service->getActive();

    expect($theme['meta']['slug'] ?? '')->toBe('hlstatsx-dark');
});
