<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Fetch the chat list for the authenticated user
    // public function getChatList()
    // {
    //     $chats = Chat::where('user_one', Auth::id())
    //                 ->orWhere('user_two', Auth::id())
    //                 ->with(['userOne', 'userTwo'])
    //                 ->get();

    //     return response()->json($chats);
    // }

    // Fetch messages for a specific chat
    public function getMessages($chatId)
    {
        $messages = Message::with('attachments')
            ->where('chat_id', $chatId)
            ->get();

        return response()->json($messages);
    }

    // Send a new message
    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'chat_id' => $request->chat_id,
            'sender_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json($message->load('sender'));
    }

    public function createNewChat(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $currentUserId = Auth::id();
        $otherUserId = $validatedData['user_id'];

        // Check if a chat already exists between these users
        $existingChat = Chat::where(function ($query) use ($currentUserId, $otherUserId) {
            $query->where('user_one', $currentUserId)
                ->where('user_two', $otherUserId);
        })->orWhere(function ($query) use ($currentUserId, $otherUserId) {
            $query->where('user_one', $otherUserId)
                ->where('user_two', $currentUserId);
        })->first();

        if ($existingChat) {
            return redirect()->route('messages.index', $existingChat->id);
        }

        // Create a new chat
        $newChat = Chat::create([
            'user_one' => $currentUserId,
            'user_two' => $otherUserId,
        ]);

        return redirect()->route('messages.index', $newChat->id);
    }

    public function show($id)
    {
        $chat = Chat::findOrFail($id);
        $messages = $chat->messages()->orderBy('created_at', 'asc')->get();
        $otherUser = ($chat->user_one == Auth::id()) ? $chat->userTwo : $chat->userOne;

        return view('messages.index', compact('chat', 'messages', 'otherUser'));
    }
}
