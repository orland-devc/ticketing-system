@section('title', 'Knowledge Base')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Knowledge Base
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">Add Knowledge Base Entry</h2>
                    <form action="{{ route('knowledge-bases.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <input type="text" name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700">Question</label>
                            <input type="text" name="question" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        </div>
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700">Answer</label>
                            <textarea name="answer" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required></textarea>
                        </div>
                        <x-primary-button type="submit">
                            Save
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
