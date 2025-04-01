<div class="mb-2 p-2 {{ $chat->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">
    <div class="inline-block bg-gray-200 p-2 rounded-lg">
        <p>{{ $chat->content }}</p>
        <small class="text-gray-400">{{ formatChatTime($chat->created_at) }}</small>
    </div>
</div>
