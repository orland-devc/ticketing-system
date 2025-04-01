@section('title', 'Chats')

@php
    use Carbon\Carbon;

    function truncateMessage($message, $limit = 20)
    {
        return strlen($message) > $limit ? substr($message, 0, $limit) . '...' : $message;
    }
    function formatChatTime($timestamp)
    {
        $time = Carbon::parse($timestamp);
        $now = Carbon::now();

        if ($time->diffInSeconds($now) < 60) {
            return 'just now';
        } elseif ($time->isToday()) {
            return $time->format('h:i A');
        } elseif ($time->diffInHours($now) < 24) {
            return $time->format('h:i A');
        } elseif ($time->diffInDays($now) < 7) {
            return $time->format('l'); // Day of the week
        } elseif ($time->diffInDays($now) < 365) {
            return $time->format('M d'); // Short month and day
        } else {
            return $time->format('M d Y'); // Short month, day, and year
        }
    }
@endphp

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
            <ion-icon class="ml-2" name="chatbubble-ellipses"></ion-icon>
        </h2>
    </x-slot>

    <div class="max-w-screen bg-gray-200 flex p-3 absolute" style="bottom: 0; top: 62px; right: 0; left: 280px;">
        <div class="bg-white border-0 shadow-lg rounded-lg mr-2 w-1/4 min-w-72 h-2xl">
            <div class="flex items-center text-2xl m-auto px-4 py-3" style="justify-content: space-between">
                <h2 class="text-xl font-semibold text-gray-800 text-center">Chats</h2>
                <a href="#" class="options">
                    <ion-icon name="create-outline" style="margin-top: 4px;"></ion-icon>   
                </a>
            </div>
            <hr class="border">
            {{-- Chat list will be dynamically loaded here --}}
            <div id="chat-list">
                @include('messages.chatl-list')
                {{-- @foreach($contacts as $contact)
                <div class="p-4 flex items-center chat-contact hover:bg-gray-100 cursor-pointer" style="justify-content: space-between" data-id="{{ $contact->id }}">
                    <div class="flex items-center">
                        <img src="{{ $contact->otherUser->profile_picture ? asset($contact->otherUser->profile_picture) : asset('images/default-profile.png') }}" alt="{{ $contact->otherUser->name }}" class="h-12 rounded-full mr-2 border border-gray-400">
                        <div>
                            <h3 class="text-xl font-semibold">
                                {{ Str::limit($contact->otherUser->name, 12, '...') }}
                            </h3>
                            <p class="">
                                @if ($contact->lastMessage->sender_id == Auth::id())
                                    {{ Str::limit('You: ' . $contact->lastMessage->content, 17, '...') }}
                                @else
                                    {{ Str::limit($contact->lastMessage->content, 19, '...') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="">{{ formatChatTime($contact->lastMessage->created_at) }}</p>
                    </div>
                </div>
                @endforeach --}}
            </div>            
        </div>
        
        <div class="bg-white border-0 shadow-lg rounded-lg mx-2 w-3/4 min-w-72 h-2xl flex flex-col hidden">
            <div class="m-auto text-center items-center" style="justify-content: space-between">
                <p class="bg-blue-100 py-1 px-3 rounded-full">Select a chat to start messaging</p>

            </div>
        </div>
        

        <div class="bg-white border-0 shadow-lg rounded-lg mx-2 w-3/4 min-w-72 h-2xl flex flex-col">
            <div class="overflow-y-auto autoScroll flex-grow">
                <div>
                    <div class="flex items-center text-2xl m-auto px-4 py-2" style="justify-content: space-between">
                        {{-- <ion-icon name="ticket" class="mr-2 text-gray-400" style="margin-top: -5px;"></ion-icon> --}}
                        <div class="flex items-center gap-3">
                            <!-- <img src="{{-- profile picture of the user --}}" class="w-10 h-10 rounded-full" alt=""> -->
                            <img src="{{ asset('images/image.png') }}" class="w-10 h-10 rounded-full" alt="">
                            <div>
                                <h2 class="text-2xl font-semibold text-gray-800 text-center">
                                    {{-- Name here --}}
                                    Cmark Aquino
                                </h2>
                                <p class="text-sm text-green-500 flex items-center"><ion-icon class="mr-2" name="ellipse"></ion-icon>
                                    {{-- if online --}}
                                    Online
                                </p>
                            </div>
                            
                        </div>
                        
                        <a href="#" class="options">
                            <ion-icon name="ellipsis-horizontal" style="margin-top: 4px;"></ion-icon>
                        </a>
                    </div>
                    <hr class="border">
        
                    <div class="chat-conversation w-3/4 h-2xl">
                        {{-- Conversation will be dynamically loaded here --}}
                        <div id="conversation-area">
                            <!-- Messages will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-0 p-4 pb-2 bg-white rounded-md flex-shrink-0">
                <form action="" method="POST" style="margin: 0; padding: 0;">
                    @csrf
                    <div class="flex items-center">
                        <a href="#"><ion-icon name="duplicate" class="cursor-pointer text-4xl text-gray-600 hover:text-blue-700"></ion-icon></a>
                        <textarea name="content" class="border-gray-300 appearance-none border rounded w-full py-2 mx-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" id="comment" placeholder="Type a message..." autofocus></textarea>
                        <submit class="cursor-pointer flex items-center bg-white hover:text-blue-700 text-blue-500 font-semibold ml-2 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500" type="">
                            <ion-icon class="text-4xl" name="send"></ion-icon>
                        </submit>
                    </div>
                    
                </form>
            </div>

            
        </div>
        

        <div class="bg-white border-0 shadow-lg rounded-lg ml-2 w-1/4 min-w-72 h-2xl select-none">
            <div class="flex items-center text-2xl m-auto px-4 py-3" style="justify-content: space-between">
                <h2 class="text-2xl font-semibold text-gray-800 text-center">
                    Media & Files
                </h2>
                <a href="#" class="options">
                    <ion-icon name="ellipsis-horizontal" style="margin-top: 4px;"></ion-icon>
                </a>
            </div>
            <hr class="border">

            <div class="p-4" style="justify-content: space-between" data-url="tickets">
                <div class="border-2 flex font-bold uppercase rounded-md">
                    <a href="#" class="flex-1 text-center hover:bg-gray-100 media-active" style="border-radius: 6px 0 0 6px">
                        Media
                    </a>
                    <a href="#" class="flex-1 text-center hover:bg-gray-100" style="border-radius: 0 6px 6px 0">
                        Files
                    </a>
                </div>
                <p class="mt-5"><i>No media sent.</i></p>
            </div>
       </div>
    </div>
</x-app-layout>

<style>
    .options {
        padding: 3px 8px;
        border-radius: 50%;
        align-items: center;
        align-content: center;
        transition: background-color 0.2s ease;
    }
    .options:hover {
        background-color: #eceff6;
    }
    .media-active {
        background: #073194 !important;
        color: #fff;
        pointer-events: none;
    }
    .active {
        background: rgb(204, 212, 227) !important;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Load the chat list periodically
    function loadChatList() {
        $.ajax({
            url: "{{ route('chat.list') }}",
            method: "GET",
            success: function(data) {
                $('#chat-list').html(data);
            }
        });
    }

    // Periodically update the chat list
    setInterval(loadChatList, 5000);

    // Load the conversation when a contact is clicked
    $(document).on('click', '.chat-contact', function() {
        var contactId = $(this).data('id');
        $('.chat-contact').removeClass('active');
        $(this).addClass('active');

        $.ajax({
            url: "{{ route('chat.conversation') }}",
            method: "GET",
            data: { contact_id: contactId },
            success: function(data) {
                $('#conversation-area').html(data);
            }
        });
    });

    // Send a new message via AJAX
    $('#send-message').on('click', function() {
        var message = $('#message-input').val();
        var contactId = $('.chat-contact.active').data('id');

        if(message !== '') {
            $.ajax({
                url: "{{ route('chat.send') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    contact_id: contactId,
                    message: message
                },
                success: function(data) {
                    $('#conversation-area').append(data); // Append the new message
                    $('#message-input').val(''); // Clear the input
                }
            });
        }
    });
});
</script>

