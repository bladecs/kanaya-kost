<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil daftar chat terakhir (sidebar)
        $messages = Message::select('user_id', 'content', 'created_at', 'updated_at')
            ->where('is_admin', false) // Hanya pesan dari user (bukan admin)
            ->with('user:id,name')
            ->orderByDesc('created_at')
            ->get()
            ->unique('user_id')
            ->map(function ($message) use ($userId) {
                $unreadCount = Message::where('user_id', $message->user_id)
                    ->where('is_read', false)
                    ->where('is_admin', false) // Hanya pesan dari user
                    ->count();

                return [
                    'user_id' => $message->user_id,
                    'last_message' => $message->content,
                    'updated_at' => $message->updated_at,
                    'user' => $message->user,
                    'unread_count' => $unreadCount // Langsung dihitung
                ];
            })
            ->values();

        // 3. Ambil isi chat
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
                    'is_read' => $message->is_read,
                    'user' => $message->user
                ];
            });

        return response()->json([
            'messages' => $messages,
            'chat' => $chat
        ]);
    }

    public function userMessages()
    {
        $userId = Auth::id();

        // 1. Ambil semua chat user dengan admin
        $messages = Message::where('user_id', $userId)
            ->with('user:id,name') // Data user pengirim
            ->orderBy('created_at')
            ->get()
            ->map(function ($message) use ($userId) {
                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'created_at' => $message->created_at,
                    'is_admin' => $message->is_admin,
                    'is_read' => $message->is_read,
                    'user' => $message->user
                ];
            });

        // 2. Hitung unread count (pesan dari admin yang belum dibaca)
        $unreadCount = Message::where('user_id', $userId)
            ->where('is_admin', true) // Hanya pesan dari admin
            ->where('is_read', false)
            ->count();

        return response()->json([
            'messages' => $messages,
            'unread_count' => $unreadCount // Total pesan belum dibaca
        ]);
    }

    public function markAsRead($userId)
    {
        Message::where('user_id', $userId)
            ->where('is_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markUserMessagesAsRead()
    {
        $userId = Auth::id();

        Message::where('user_id', $userId)
            ->where('is_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
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
            'is_read' => $request->is_admin
        ]);

        return response()->json($message, 201);
    }
}
