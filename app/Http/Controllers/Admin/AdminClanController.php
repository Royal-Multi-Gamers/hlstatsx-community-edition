<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clan;
use Illuminate\Http\Request;

class AdminClanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $clans = Clan::when($search, fn($q) => $q->where('name', 'like', '%' . $search . '%')->orWhere('tag', 'like', '%' . $search . '%'))
            ->orderByDesc('clanId')
            ->paginate(50);
        return view('admin.clans.index', compact('clans', 'search'));
    }

    public function edit(int $id)
    {
        $clan = Clan::findOrFail($id);
        return view('admin.clans.edit', compact('clan'));
    }

    public function update(Request $request, int $id)
    {
        $clan = Clan::findOrFail($id);
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:128'],
            'tag'   => ['required', 'string', 'max:32'],
            'homepage' => ['nullable', 'url'],
        ]);
        $clan->update($data);
        return redirect()->route('admin.clans.index')->with('success', 'Clan updated.');
    }

    public function destroy(int $id)
    {
        Clan::findOrFail($id)->delete();
        return redirect()->route('admin.clans.index')->with('success', 'Clan deleted.');
    }
}
