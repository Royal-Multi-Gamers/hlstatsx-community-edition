<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Game;
use Illuminate\Http\Request;

class AdminAwardController extends Controller
{
    public function index(Request $request)
    {
        $games  = Game::orderBy('name')->get();
        $game   = $request->input('game', $games->first()?->code);
        $type   = $request->input('type', 'W');
        $awards = Award::where('game', $game)->where('awardType', $type)->orderBy('name')->get();
        return view('admin.awards.index', compact('games', 'game', 'type', 'awards'));
    }

    public function create(Request $request)
    {
        $games = Game::orderBy('name')->get();
        $selectedGame = $request->input('game', $games->first()?->code);
        $selectedType = $request->input('type', 'W');
        return view('admin.awards.create', compact('games', 'selectedGame', 'selectedType'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'game'      => ['required', 'string', 'exists:hlstats_Games,code'],
            'awardType' => ['required', 'in:W,1,2'],
            'code'      => ['required', 'string', 'max:128'],
            'name'      => ['required', 'string', 'max:128'],
            'verb'      => ['nullable', 'string', 'max:128'],
        ]);
        Award::create($data);
        return redirect()->route('admin.awards.index', ['game' => $data['game'], 'type' => $data['awardType']])->with('success', 'Award created.');
    }

    public function edit(int $id)
    {
        $award = Award::findOrFail($id);
        $games = Game::orderBy('name')->get();
        return view('admin.awards.edit', compact('award', 'games'));
    }

    public function update(Request $request, int $id)
    {
        $award = Award::findOrFail($id);
        $data  = $request->validate([
            'game'      => ['required', 'string', 'exists:hlstats_Games,code'],
            'awardType' => ['required', 'in:W,1,2'],
            'code'      => ['required', 'string', 'max:128'],
            'name'      => ['required', 'string', 'max:128'],
            'verb'      => ['nullable', 'string', 'max:128'],
        ]);
        $award->update($data);
        return redirect()->route('admin.awards.index', ['game' => $award->game, 'type' => $award->awardType])->with('success', 'Award updated.');
    }

    public function destroy(int $id)
    {
        $award = Award::findOrFail($id);
        $game  = $award->game;
        $type  = $award->awardType;
        $award->delete();
        return redirect()->route('admin.awards.index', ['game' => $game, 'type' => $type])->with('success', 'Award deleted.');
    }
}
