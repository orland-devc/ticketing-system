<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function getMessages($chatId)
    {
        $messages = Message::with('attachments')
            ->where('chat_id', $chatId)
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        try {
            // Validate request - validation remains the same since it was already correct
            $request->validate([
                'chat_id' => 'required|exists:chats,id',
                'content' => 'nullable|string',
                'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
            ]);

            $uploadsDirectory = 'images/uploads/';

            // Start database transaction
            DB::beginTransaction();

            // Create message - now explicitly checking if content is empty
            $message = Message::create([
                'chat_id' => $request->chat_id,
                'sender_id' => Auth::id(),
                'content' => $request->content ?: null, // Convert empty string to null
            ]);

            $attachments = [];

            // Handle file attachments
            if ($request->hasFile('attachments2')) {
                foreach ($request->file('attachments2') as $file) {
                    $fileName = time().'_'.uniqid().'_'.$file->getClientOriginalName();
                    $fileSize = $file->getSize();

                    try {
                        $file->move(public_path($uploadsDirectory), $fileName);

                        $attachment = Attachment::create([
                            'sender_id' => Auth::id(),
                            'message_id' => $message->id,
                            'file_name' => $file->getClientOriginalName(),
                            'file_size' => $fileSize,
                            'file_location' => $uploadsDirectory.$fileName,
                            'file_type' => $file->getClientMimeType(),
                        ]);

                        $attachments[] = $attachment;
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json([
                            'success' => false,
                            'message' => 'Failed to upload file: '.$file->getClientOriginalName(),
                            'error' => $e->getMessage(),
                        ], 500);
                    }
                }
            }

            // Only commit if we have either content or attachments
            if (! empty($request->content) || ! empty($attachments)) {
                DB::commit();

                $message->load(['sender', 'attachments']);

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'chat_id' => $message->chat_id,
                    'attachments' => $attachments,
                ]);
            } else {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Message must contain either text content or attachments',
                ], 422);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please write something to send an attachment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $userId = Auth::id();

        $users = User::where('id', '!=', $userId)->get();

        $chats = Chat::where('user_one', $userId)
            ->orWhere('user_two', $userId)
            ->get()
            ->map(function ($chat) use ($userId) {
                $chatPartnerId = $chat->user_one == $userId ? $chat->user_two : $chat->user_one;
                $chatPartner = User::find($chatPartnerId);

                $latestMessage = Messages::where('chat_id', $chat->id)
                    ->latest()
                    ->first();

                $chat->chat_partner = $chatPartner;
                $chat->latest_message = $latestMessage;

                return $chat;
            });

        $chats = $chats->sortByDesc(function ($chat) {
            return $chat->latest_message->created_at ?? null;
        });

        $sortedUsers = $users->sortBy(function ($user) use ($chats) {
            $chat = $chats->firstWhere('chat_partner.id', $user->id);

            return $chat && $chat->latest_message ? $chat->latest_message->created_at : null;
        })->sortByDesc(function ($user) use ($chats) {
            $chat = $chats->firstWhere('chat_partner.id', $user->id);

            return $chat && $chat->latest_message ? $chat->latest_message->created_at : now()->subYear();
        });

        return view('messages.index', compact('sortedUsers', 'chats'));
    }

    public function dashboard()
    {
        $userId = Auth::id();

        $users = User::where('id', '!=', $userId)->get();

        $chats = Chat::where('user_one', $userId)
            ->orWhere('user_two', $userId)
            ->limit(3)
            ->get()
            ->map(function ($chat) use ($userId) {
                $chatPartnerId = $chat->user_one == $userId ? $chat->user_two : $chat->user_one;
                $chatPartner = User::find($chatPartnerId);

                $latestMessage = Messages::where('chat_id', $chat->id)
                    ->latest()
                    ->first();

                $chat->chat_partner = $chatPartner;
                $chat->latest_message = $latestMessage;

                return $chat;
            });

        $chats = $chats->sortByDesc(function ($chat) {
            return $chat->latest_message->created_at ?? null;
        });

        $sortedUsers = $users->sortBy(function ($user) use ($chats) {
            $chat = $chats->firstWhere('chat_partner.id', $user->id);

            return $chat && $chat->latest_message ? $chat->latest_message->created_at : null;
        })->sortByDesc(function ($user) use ($chats) {
            $chat = $chats->firstWhere('chat_partner.id', $user->id);

            return $chat && $chat->latest_message ? $chat->latest_message->created_at : now()->subYear();
        });

        return view('dashboard', compact('sortedUsers', 'chats'));
    }

    public function getLatestChats()
    {
        $userId = Auth::id();

        // Fetch all users except the authenticated user
        $users = User::where('id', '!=', $userId)->get();

        // Fetch the list of chats involving the authenticated user
        $chats = Chat::where('user_one', $userId)
            ->orWhere('user_two', $userId)
            ->with('attachments') // Eager load attachments
            ->get()
            ->map(function ($chat) use ($userId) {
                // Determine the chat partner (the other user in the chat)
                $chatPartnerId = $chat->user_one == $userId ? $chat->user_two : $chat->user_one;
                $chatPartner = User::find($chatPartnerId); // Fetch the chat partner's details

                // Get the latest message for this chat
                $latestMessage = Messages::where('chat_id', $chat->id)
                    ->latest() // Get the most recent message
                    ->first();

                // Add the chat partner and latest message to the chat object
                $chat->chat_partner = $chatPartner;
                $chat->latest_message = $latestMessage;

                return $chat;
            });

        // Sort chats by the created_at of the latest message in descending order
        $chats = $chats->sortByDesc(function ($chat) {
            return $chat->latest_message->created_at ?? null; // Use null if no message exists
        })->values(); // Reset array keys

        // Sort users based on the latest_message created_at (those without messages are at the bottom)
        $sortedUsers = $users->sortBy(function ($user) use ($chats) {
            $chat = $chats->firstWhere('chat_partner.id', $user->id);

            return $chat && $chat->latest_message ? $chat->latest_message->created_at : null;
        })->sortByDesc(function ($user) use ($chats) {
            $chat = $chats->firstWhere('chat_partner.id', $user->id);

            return $chat && $chat->latest_message ? $chat->latest_message->created_at : now()->subYear(); // Fallback to old date for users with no chats
        })->values(); // Reset array keys

        // Return both chats and sorted users
        return response()->json([
            'chats' => $chats,
            'sortedUsers' => $sortedUsers,
        ]);
    }

    public function show($id)
    {
        $userId = Auth::id();
        $messages = Messages::where(function ($query) use ($id, $userId) {
            $query->where('sender_id', $userId)->where('receiver_id', $id);
        })->orWhere(function ($query) use ($id, $userId) {
            $query->where('sender_id', $id)->where('receiver_id', $userId);
        })->get();

        $chatWith = User::find($id)->name;

        return response()->json([
            'chatWith' => $chatWith,
            'messages' => $messages,
            'currentUserId' => $userId,
        ]);
    }

    public function store(Request $request, $id)
    {
        $userId = Auth::id();

        $message = Messages::create([
            'sender_id' => $userId,
            'receiver_id' => $id,
            'body' => $request->body,
            'is_read' => false,
            'is_archived' => false,
        ]);

        return response()->json($message);
    }

    public function searchUsers(Request $request)
    {
        $query = $request->query('query');
        $users = User::where('name', 'like', '%'.$query.'%')
            ->where('id', '!=', Auth::id())
            ->get();

        return response()->json($users);
    }

    public function startNewChat(Request $request)
    {
        $chat = Chat::create([
            'user_one' => Auth::id(),
            'user_two' => $request->receiver_id,
        ]);

        $message = Messages::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json(['chat_id' => $chat->id, 'message' => $message]);
    }

    public function getOrCreateChat($userId)
    {
        $authUserId = Auth::id();

        $chat = Chat::where(function ($query) use ($authUserId, $userId) {
            $query->where('user_one', $authUserId)->where('user_two', $userId);
        })->orWhere(function ($query) use ($authUserId, $userId) {
            $query->where('user_one', $userId)->where('user_two', $authUserId);
        })->first();

        if (! $chat) {
            return response()->json(['chat' => null]);
        }

        return response()->json(['chat' => $chat]);
    }
}
