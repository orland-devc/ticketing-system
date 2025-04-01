@section('title', 'Main Menu')

<x-users-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Main Menu') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Chatbot -->
                        <div class="bg-white border shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Ask the Chatbot</h3>
                            <div>
                                <div class="bg-gray-100 p-4 rounded-lg h-64 overflow-y-auto mb-4 flex justify-center items-center">
                                    <img src="{{asset('images/bot.png')}}" width="220">
                                </div>
                                <div class="mb-4">
                                    <a href="tickets/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Submit a ticket
                                    </a>
                                </div>
    
                                {{-- <div id="chatbot-messages" class="bg-gray-100 p-4 rounded-lg h-64 overflow-y-auto mb-4">
                                    <img src="{{asset('images/bot.png')}}" width="220">
                                </div> --}}
                                {{-- <form id="chatbot-form">
                                    <div class="flex">
                                        <input type="text" id="chatbot-input" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Type your question...">
                                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded ml-2">
                                            Send
                                        </button>
                                    </div>
                                </form> --}}
                            </div>
                        </div>

                        <!-- Ticket Status -->
                        <div class="bg-white border shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Ticket Status</h3>
                            <div class="mb-4">
                                <a href="tickets/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Submit a ticket
                                </a>
                            </div>
                            <ul>

                                    <p>No tickets found.</p>
                            </ul>
                        </div>

                        <!-- Recent Announcements -->
                        <div class="bg-white border shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Recent Announcements</h3>
                            <ul>
                                    <p>No announcements found.</p>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-users-layout>