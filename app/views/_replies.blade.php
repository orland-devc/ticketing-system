<div class="space-y-4">
    <div class="replies-container">
        @forelse ($ticket->replies as $reply)
            <div class="bg-white p-4 rounded-lg border border-2 mb-2 shadow-sm">
                <div class="flex items-start">
                    @if ($reply->sender->profile_picture)
                        <img src="{{ asset($reply->sender->profile_picture) }}" alt="{{ $reply->sender->name }}" class="h-12 rounded-full mr-2 border border-gray-400">
                    @else
                        <div class="h-12 w-12 text-2xl font-bold rounded-full flex items-center justify-center mr-2 border border-gray-400 bg-gray-200 text-gray-600">
                            {{ strtoupper(substr($reply->sender->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="none">
                        <p class="text-sm font-semibold">{{ $reply->sender->name }}</p>
                        <span class="text-xs text-gray-500">{{ $reply->created_at->format('M d, Y h:i A') }}</span>
                        <p class="text-gray-700 mt-5">{{ $reply->content }}</p>
                    </div>
                </div>

                {{-- @if ($reply->childReplies->isNotEmpty())
                    <div class="mt-4 pl-6">
                        @foreach ($reply->childReplies as $childReply)
                            <div class="bg-gray-100 p-4 rounded-lg shadow mb-2 transition-colors duration-200 hover:bg-gray-200">
                                <div class="flex items-center mb-2">
                                    <img src="{{ $ticket->user->profile_picture }}" alt="{{ $childReply->sender->name }}" class="h-8 w-8 rounded-full mr-2">
                                    <p class="text-sm font-semibold">{{ $childReply->sender->name }}</p>
                                    <span class="text-xs text-gray-500 ml-2">{{ $childReply->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <p class="text-gray-700">{{ $childReply->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif --}}
            </div>
        @empty
        <div class="bg-white p-4 rounded-lg border border-2 mb-2 shadow-sm">
            <p class="text-gray-500 italic">No replies yet.</p>
        </div>
        @endforelse
    </div>

</div>

