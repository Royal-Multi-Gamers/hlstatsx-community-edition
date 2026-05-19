<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminBanController extends Controller
{
    public function __construct(private AdminService $admin) {}

    public function index()
    {
        $bans = Ban::with('player')->orderByDesc('created')->paginate(50);
        return view('admin.bans.index', compact('bans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'player_id' => ['required', 'integer'],
            'reason'    => ['nullable', 'string', 'max:255'],
            'days'      => ['nullable', 'integer', 'min:1'],
        ]);

        $this->admin->banPlayer(
            (int)$data['player_id'],
            $data['reason'] ?? '',
            $data['days'] ?? null,
        );

        return back()->with('success', 'Player banned.');
    }

    public function destroy(int $id)
    {
        $this->admin->unbanPlayer($id);
        return back()->with('success', 'Ban removed.');
    }
}
