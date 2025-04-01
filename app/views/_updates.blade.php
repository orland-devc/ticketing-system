<div>
    <div class="flex items-center space-x-3 mt-2 top-options">
        @if ($ticket->status == 'closed')
            <p class="italic text-sm">This ticket has been closed at {{ $ticket->updated_at->format('M d, Y h:i A') }}</p>
        @else
            <a href="#" onclick="showAssignTab()" class="options px-4 py-2 hover:bg-blue-200" title="Assign">
                <i class="fas fa-reply mr-2"></i>
                Reply
            </a>
            @if (empty($ticket->assigned_to))
                <a href="#" onclick="showAssignTab()" class="options px-4 py-2 hover:bg-blue-200" title="Assign">
                    <i class="fas fa-share mr-2"></i>
                    Forward
                </a>
            @else
                <a href="#" class="options px-4 py-2 hover:bg-blue-200">
                    <i class="fas fa-share mr-2"></i>
                    Forwarded to {{$ticket->ticket->name}}
                </a>
            @endif

            <a href="#" class="options px-4 py-2 hover:bg-blue-200">
                <i class="fas fa-edit mr-2"></i>
                Add Note
            </a>
            {{-- <form method="POST" action="{{ route('tickets.unread', $ticket) }}">
                @csrf
                @method('PUT')
                <button type="submit" class="top-option" title="Mark as unread">
                    <ion-icon name="mail-unread-outline" class="text-gray-600 hover:text-blue-500 transition-colors duration-200"></ion-icon>
                </button>
            </form>
            <a href="#" class="top-option" title="Archive">
                <ion-icon name="archive-outline" class="text-gray-600 hover:text-blue-500 transition-colors duration-200"></ion-icon>
            </a> --}}
            <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                @csrf
                @method('PUT')
                <button class="bg-blue-400 text-white px-4 py-2 rounded-md font-bold">
                    <i class="far fa-check-circle mr-2"></i>
                    Close Ticket
                </button>
            </form>
        @endif
    </div>
</div>


<style>
    .options {
        font-size: 18px;
        display: flex;
        align-items: center;
        background: #f0f9ff;
        border-radius: 6px;
        color: #0076b0;
        font-size: 16px;
    }
</style>