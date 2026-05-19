<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Weapon;
use Illuminate\Http\Request;

class AdminWeaponController extends Controller
{
    public function index(Request $request)
    {
        $game    = $request->query('game');
        $weapons = Weapon::when($game, fn($q) => $q->where('game', $game))
            ->orderBy('game')->orderBy('name')
            ->paginate(50);
        return view('admin.weapons.index', compact('weapons', 'game'));
    }

    public function edit(int $id)
    {
        $weapon = Weapon::findOrFail($id);
        return view('admin.weapons.edit', compact('weapon'));
    }

    public function update(Request $request, int $id)
    {
        $weapon = Weapon::findOrFail($id);
        $data   = $request->validate([
            'name'    => ['required', 'string', 'max:64'],
            'modifier' => ['nullable', 'numeric'],
        ]);
        $weapon->update($data);
        return redirect()->route('admin.weapons.index')->with('success', 'Weapon updated.');
    }

    public function destroy(int $id)
    {
        Weapon::findOrFail($id)->delete();
        return redirect()->route('admin.weapons.index')->with('success', 'Weapon deleted.');
    }
}
