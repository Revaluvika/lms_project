<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return view('pages.chat.index', compact('users'));
    }

    public function chatWith($id)
    {
        $user = User::findOrFail($id);

        // Ambil semua percakapan
        $messages = Message::where(function ($q) use ($id) {
            $q->where('pengirim_id', Auth::id())
                ->where('penerima_id', $id);
        })
            ->orWhere(function ($q) use ($id) {
                $q->where('pengirim_id', $id)
                    ->where('penerima_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get();

        // Tandai pesan sebagai dibaca
        Message::where('penerima_id', Auth::id())
            ->where('pengirim_id', $id)
            ->update(['is_read' => true]);

        return view('pages.chat.room', compact('user', 'messages'));
    }

    public function send(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required',
        ]);

        Message::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $id,
            'pesan' => $request->pesan,
        ]);

        return back();
    }
}
