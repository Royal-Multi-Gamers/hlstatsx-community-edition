<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostGroup;
use Illuminate\Http\Request;

class AdminHostGroupController extends Controller
{
    public function index()
    {
        $groups = HostGroup::orderBy('name')->get();
        return view('admin.host-groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.host-groups.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'pattern' => ['required', 'string', 'max:255'],
        ]);
        HostGroup::create($data);
        return redirect()->route('admin.host-groups.index')->with('success', 'Host group created.');
    }

    public function edit(int $id)
    {
        $group = HostGroup::findOrFail($id);
        return view('admin.host-groups.edit', compact('group'));
    }

    public function update(Request $request, int $id)
    {
        $group = HostGroup::findOrFail($id);
        $data  = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'pattern' => ['required', 'string', 'max:255'],
        ]);
        $group->update($data);
        return redirect()->route('admin.host-groups.index')->with('success', 'Host group updated.');
    }

    public function destroy(int $id)
    {
        HostGroup::findOrFail($id)->delete();
        return redirect()->route('admin.host-groups.index')->with('success', 'Host group deleted.');
    }
}
