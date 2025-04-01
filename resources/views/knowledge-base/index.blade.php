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
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Knowledge Base</h2>
                        <a href="{{ route('knowledge-bases.create') }}" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add New Entry</a>
                    </div>
                    
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Category</th>
                                <th class="py-2 px-4 border-b">Question</th>
                                <th class="py-2 px-4 border-b">Answer</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entries as $entry)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $entry->category }}</td>
                                    <td class="py-2 px-4 border-b">{{ $entry->question }}</td>
                                    <td class="py-2 px-4 border-b">{{ $entry->answer }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('knowledge-bases.edit', $entry->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-700">Edit</a>
                                            <form action="{{ route('knowledge-bases.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
