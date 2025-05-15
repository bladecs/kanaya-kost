<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        // Untuk message list (sidebar)
        $messages = Message::select('user_id', 'content', 'created_at','updated_at')
            ->where('is_admin', false)
            ->with('user:id,name')
            ->orderByDesc('created_at')
            ->get()
            ->unique('user_id')
            ->values();

        // Untuk chat content (flat structure)
        $chat = Message::with('user:id,name')
            ->orderBy('created_at')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'user_id' => $message->user_id,
                    'content' => $message->content,
                    'created_at' => $message->created_at,
                    'is_admin' => $message->is_admin,
                    'user' => $message->user
                ];
            });

        return response()->json([
            'messages' => $messages,
            'chat' => $chat
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'is_admin' => 'required|boolean',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $message = Message::create([
            'user_id' => $request->user_id,
            'content' => $request->content,
            'is_admin' => $request->is_admin,
        ]);

        return response()->json($message, 201);
    }
}