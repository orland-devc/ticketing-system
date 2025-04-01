@foreach($contacts as $contact)
<div class="contact-item p-4 chat-contact flex items-center hover:bg-gray-100 cursor-pointer" style="justify-content: space-between" data-contact-id="{{ $contact->sender_id == Auth::id() ? $contact->receiver_id : $contact->sender_id }}">
    <div>
        <h3 class="flex items-center text-lg font-semibold text-gray-800">
            {{ Str::limit($contact->sender_id == Auth::id() ? $contact->receiver->name : $contact->sender->name, 20) }}
            @if ($contact->sender_id == Auth::id() ? $contact->receiver->is_active : $contact->sender->is_active == '1')
                <ion-icon name="ellipse" class="text-green-500 ml-2 text-sm"></ion-icon>
            @endif
        </h3>        
        <p class="text-md text-gray-400">
            @if ($contact->lastMessage->sender_id == Auth::id())
                You:
            @endif
            {{ truncateMessage($contact->lastMessage->content) }}
        </p>
    </div>
    <div>
        <p class="text-sm text-gray-400">
            {{ formatChatTime($contact->lastMessage->created_at) }}
        </p>
    </div>
</div>
@endforeach