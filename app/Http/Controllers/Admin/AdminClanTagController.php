<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClanTag;
use Illuminate\Http\Request;

class AdminClanTagController extends Controller
{
    public function index()
    {
        $tags = ClanTag::orderBy('pattern')->get();
        return view('admin.clan-tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.clan-tags.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pattern'  => ['required', 'string', 'max:64', 'unique:hlstats_ClanTags,pattern'],
            'position' => ['required', 'in:EITHER,START,END'],
        ]);
        ClanTag::create($data);
        return redirect()->route('admin.clan-tags.index')->with('success', 'Clan tag created.');
    }

    public function edit(int $id)
    {
        $tag = ClanTag::findOrFail($id);
        return view('admin.clan-tags.edit', compact('tag'));
    }

    public function update(Request $request, int $id)
    {
        $tag  = ClanTag::findOrFail($id);
        $data = $request->validate([
            'pattern'  => ['required', 'string', 'max:64', 'unique:hlstats_ClanTags,pattern,' . $id],
            'position' => ['required', 'in:EITHER,START,END'],
        ]);
        $tag->update($data);
        return redirect()->route('admin.clan-tags.index')->with('success', 'Clan tag updated.');
    }

    public function destroy(int $id)
    {
        ClanTag::findOrFail($id)->delete();
        return redirect()->route('admin.clan-tags.index')->with('success', 'Clan tag deleted.');
    }
}
