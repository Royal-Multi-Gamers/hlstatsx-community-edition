<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EventChat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $game = $request->query('game', '');

        $messages = EventChat::with(['player', 'server'])
            ->when($game, fn($q) => $q->whereHas('server', fn($sq) => $sq->where('game', $game)))
            ->orderByDesc('eventTime')
            ->paginate(100);

        return view('frontend.chat.index', compact('messages', 'game'));
    }
}
