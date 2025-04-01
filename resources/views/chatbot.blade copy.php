<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chatbot') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Chatbot Configuration -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Chatbot Configuration</h3>
                            <form action="{{ route('chatbot.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700 font-bold mb-2">Chatbot Name:</label>
                                    <input type="text" id="name" name="name" value="{{ $chatbot->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                                <div class="mb-4">
                                    <label for="greeting" class="block text-gray-700 font-bold mb-2">Greeting Message:</label>
                                    <textarea id="greeting" name="greeting" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $chatbot->greeting }}</textarea>
                                </div>
                                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Save Changes</button>
                            </form>
                        </div>

                        <!-- Chatbot Analytics -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Chatbot Analytics</h3>
                            <div class="flex justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">Total Queries</p>
                                    <p class="text-2xl font-bold">{{ $totalQueries }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Resolved by Chatbot</p>
                                    <p class="text-2xl font-bold">{{ $queriesResolvedByChatbot }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Escalated Queries</p>
                                    <p class="text-2xl font-bold">{{ $escalatedQueries }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Top Query Category</p>
                                    <p class="text-2xl font-bold">{{ $topQueryCategory }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Knowledge Base Management -->
                    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Knowledge Base Management</h3>
                        <div class="mb-4">
                            <a href="{{ route('knowledgebase.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Add FAQ
                            </a>
                        </div>
                        <ul>
                            @forelse ($faqs as $faq)
                                <li class="mb-2">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-600">{{ $faq->question }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <a href="{{ route('knowledgebase.edit', $faq) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                            <form action="{{ route('knowledgebase.destroy', $faq) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <p>No FAQs found.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>