<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Ribbon;
use Illuminate\Http\Request;

class AdminRibbonController extends Controller
{
    public function index(Request $request)
    {
        $games   = Game::orderBy('name')->get();
        $game    = $request->input('game', $games->first()?->code);
        $ribbons = Ribbon::where('game', $game)->orderBy('ribbonName')->get();
        return view('admin.ribbons.index', compact('games', 'game', 'ribbons'));
    }

    public function create(Request $request)
    {
        $games = Game::orderBy('name')->get();
        $selectedGame = $request->input('game', $games->first()?->code);
        return view('admin.ribbons.create', compact('games', 'selectedGame'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'game'       => ['required', 'string', 'exists:hlstats_Games,code'],
            'ribbonName' => ['required', 'string', 'max:50'],
            'image'      => ['required', 'string', 'max:50'],
            'awardCode'  => ['required', 'string', 'max:50'],
            'awardCount' => ['required', 'integer', 'min:1'],
            'special'    => ['required', 'integer', 'min:0'],
        ]);
        Ribbon::create($data);
        return redirect()->route('admin.ribbons.index', ['game' => $data['game']])->with('success', 'Ribbon created.');
    }

    public function edit(int $id)
    {
        $ribbon = Ribbon::findOrFail($id);
        $games  = Game::orderBy('name')->get();
        return view('admin.ribbons.edit', compact('ribbon', 'games'));
    }

    public function update(Request $request, int $id)
    {
        $ribbon = Ribbon::findOrFail($id);
        $data   = $request->validate([
            'game'       => ['required', 'string', 'exists:hlstats_Games,code'],
            'ribbonName' => ['required', 'string', 'max:50'],
            'image'      => ['required', 'string', 'max:50'],
            'awardCode'  => ['required', 'string', 'max:50'],
            'awardCount' => ['required', 'integer', 'min:1'],
            'special'    => ['required', 'integer', 'min:0'],
        ]);
        $ribbon->update($data);
        return redirect()->route('admin.ribbons.index', ['game' => $ribbon->game])->with('success', 'Ribbon updated.');
    }

    public function destroy(int $id)
    {
        $ribbon = Ribbon::findOrFail($id);
        $game   = $ribbon->game;
        $ribbon->delete();
        return redirect()->route('admin.ribbons.index', ['game' => $game])->with('success', 'Ribbon deleted.');
    }
}
