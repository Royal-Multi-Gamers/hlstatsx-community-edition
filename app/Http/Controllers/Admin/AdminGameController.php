<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class AdminGameController extends Controller
{
    public function index()
    {
        $games = Game::orderBy('name')->get();
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'     => ['required', 'string', 'max:32', 'unique:hlstats_Games,code'],
            'name'     => ['required', 'string', 'max:128'],
            'realgame' => ['nullable', 'string', 'max:32'],
        ]);
        $data['hidden'] = $request->boolean('hidden') ? '1' : '0';
        Game::create($data);
        return redirect()->route('admin.games.index')->with('success', 'Game created.');
    }

    public function edit(string $code)
    {
        $game = Game::findOrFail($code);
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, string $code)
    {
        $game = Game::findOrFail($code);
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:128'],
            'realgame'   => ['nullable', 'string', 'max:32'],
        ]);
        $data['hidden'] = $request->boolean('hidden') ? '1' : '0';
        $game->update($data);
        return redirect()->route('admin.games.index')->with('success', 'Game updated.');
    }

    public function destroy(string $code)
    {
        Game::findOrFail($code)->delete();
        return redirect()->route('admin.games.index')->with('success', 'Game deleted.');
    }
}
