<?php

use App\Models\Game;
use App\Models\Player;
use App\Services\StatsService;

test('home page loads', function () {
    $this->mock(StatsService::class, function ($mock) {
        $mock->shouldReceive('getGlobalStats')->andReturn([
            'players' => 100,
            'clans'   => 10,
            'games'   => 2,
            'servers' => 5,
            'kills'   => 50000,
            'lastKill' => now(),
        ]);
    });

    $response = $this->get(route('home'));
    $response->assertStatus(200);
    $response->assertViewIs('frontend.home');
});

test('players index page loads', function () {
    $response = $this->get(route('players.index'));
    $response->assertStatus(200);
    $response->assertViewIs('frontend.players.index');
});

test('players index with game filter', function () {
    $response = $this->get(route('players.index', ['game' => 'cstrike']));
    $response->assertStatus(200);
});

test('player show returns 404 for unknown player', function () {
    $response = $this->get(route('players.show', 999999999));
    $response->assertStatus(404);
});

test('search page returns results', function () {
    $response = $this->get(route('search', ['q' => 'test']));
    $response->assertStatus(200);
    $response->assertViewIs('frontend.search');
});

test('legacy redirect works for players mode', function () {
    $response = $this->get('/hlstats.php?mode=players&game=cstrike');
    $response->assertRedirect(route('players.index', ['game' => 'cstrike']));
});
