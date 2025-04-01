@section('title', 'Main Menu')

<x-users-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight ">
            {{ __('Main Menu') }}
        </h2>
    </x-slot> --}}

    @php
        $firstName = explode(' ', Auth::user()->name)[0];
    @endphp

    <div class="py-10 bg-gray-50">
        <div class="max-w-screen-xl max-h-screen mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">
                Welcome, {{ $firstName }}!
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Tickets Section -->
                <div class="bg-white rounded-2xl shadow-xl transform transition-all hover:scale-105 hover:shadow-2xl">
                    <div class="relative overflow-hidden rounded-2xl">
                        <div class="p-6 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                            <div class="flex justify-between items-center">
                                <h3 class="text-2xl font-bold">Ticket Center</h3>
                                <div class="bg-white/20 p-3 rounded-full">
                                    <ion-icon name="ticket" class="text-3xl text-white"></ion-icon>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex flex-col gap-4">
                                <a href="#" onclick="showPostTab()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition-all transform hover:scale-105 flex items-center justify-center space-x-2">
                                    <ion-icon name="add-circle" class="mr-2"></ion-icon>
                                    Submit Ticket
                                </a>
                                <a href="my-tickets" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition-all transform hover:scale-105 flex items-center justify-center space-x-2">
                                    <ion-icon name="list" class="mr-2"></ion-icon>
                                    View Tickets
                                </a>
                            </div>
                            <div class="bg-gray-100 rounded-lg p-4 text-center">
                                <p class="text-md text-gray-600">Total Tickets: <span class="font-bold text-blue-600">{{ $myTotalTickets ?? 0 }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chatbot Section -->
                <div class="bg-white rounded-2xl shadow-xl transform transition-all hover:scale-105 hover:shadow-2xl">
                    <div class="relative overflow-hidden rounded-2xl">
                        <div class="p-6 bg-gradient-to-r from-green-500 to-teal-600 text-white">
                            <div class="flex justify-between items-center">
                                <h3 class="text-2xl font-bold">AI Chatbot</h3>
                                <div class="bg-white/20 p-3 rounded-full">
                                    <ion-icon name="chatbubble-ellipses" class="text-3xl text-white"></ion-icon>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <div class="flex justify-center mb-6">
                                <img src="{{ asset('images/animated-bot.gif') }}" alt="Chatbot" class="h-40 w-40 object-cover rounded-full border-4 border-green-500">
                            </div>
                            <a href="chatbot" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all transform hover:scale-105 flex items-center justify-center space-x-2">
                                <ion-icon name="play-circle" class="mr-2"></ion-icon>
                                Start Conversation
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Messages Section -->
                <div class="bg-white rounded-2xl shadow-xl transform transition-all hover:scale-105 hover:shadow-2xl">
                    <div class="relative overflow-hidden rounded-2xl">
                        <div class="p-6 bg-gradient-to-r from-purple-500 to-pink-600 text-white">
                            <div class="flex justify-between items-center">
                                <h3 class="text-2xl font-bold">Your Messages</h3>
                                <div class="bg-white/20 p-3 rounded-full">
                                    <ion-icon name="mail-unread" class="text-3xl text-white"></ion-icon>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($chats && count($chats) > 0)
                                <ul class="divide-y divide-gray-200">
                                    @foreach ($chats as $chat)
                                        @if (!empty($chat->latest_message->created_at))
                                            @php
                                                $chatPartner = ($chat->user_one == Auth::id()) ? $chat->userTwo : $chat->userOne;
                                            @endphp
                                            <div class="chat cursor-pointer hover:bg-indigo-100 transition ease-in-out duration-200 py-4 px-6" onclick="loadChat({{ $chat->id }}, {{ $chatPartner->id }})" data-chat-partner="{{ strtolower($chatPartner->name) }}">
                                                <div class="flex items-center">
                                                    @if (!empty($chatPartner->profile_picture))
                                                        <img src="{{ $chatPartner->profile_picture }}" alt="Profile Picture" class="w-12 h-12 rounded-full mr-4">
                                                    @else
                                                        <img src="{{ asset('images/uploads/default.jpg') }}" alt="Profile Picture" class="w-12 h-12 rounded-full mr-4">
                                                    @endif

                                                    <div class="flex-grow">
                                                        <p class="font-semibold text-gray-900 ">{{ Str::limit($chatPartner->name, 12) }}</p>
                                                        <p class="text-sm text-gray-500 truncate">{{ Str::limit($chat->latest_message->content ?? 'No messages yet', 20) }}</p>
                                                    </div>
                                                    @if (!empty($chat->latest_message->created_at))
                                                        <small class="text-xs text-gray-400">{{ $chat->latest_message->created_at->diffForHumans() }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center text-gray-500">
                                    <p>No new messages</p>
                                </div>
                            @endif
                            <div class="mt-4 text-center">
                                <a href="{{ route('messages.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-semibold">
                                    View All Messages
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-users-layout>
