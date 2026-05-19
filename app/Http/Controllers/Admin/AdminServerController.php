<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Server;
use Illuminate\Http\Request;

class AdminServerController extends Controller
{
    public function index()
    {
        $servers = Server::orderBy('game')->orderBy('name')->paginate(50);
        return view('admin.servers.index', compact('servers'));
    }

    public function create()
    {
        $games = Game::visible()->orderBy('name')->get();
        return view('admin.servers.create', compact('games'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Server::create($data);
        return redirect()->route('admin.servers.index')->with('success', 'Server created.');
    }

    public function edit(int $id)
    {
        $server = Server::findOrFail($id);
        $games  = Game::visible()->orderBy('name')->get();
        return view('admin.servers.edit', compact('server', 'games'));
    }

    public function update(Request $request, int $id)
    {
        $server = Server::findOrFail($id);
        $data   = $this->validated($request);
        $server->update($data);
        return redirect()->route('admin.servers.index')->with('success', 'Server updated.');
    }

    public function destroy(int $id)
    {
        Server::findOrFail($id)->delete();
        return redirect()->route('admin.servers.index')->with('success', 'Server deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'       => ['required', 'string', 'max:128'],
            'address'    => ['required', 'string', 'max:64'],
            'port'       => ['required', 'integer', 'min:1', 'max:65535'],
            'game'       => ['required', 'string', 'max:32'],
            'publicaddress' => ['nullable', 'string', 'max:64'],
            'rcon'       => ['nullable', 'string', 'max:64'],
        ]);
    }
}
