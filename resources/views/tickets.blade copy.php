<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('tickets.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Create Ticket
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Subject</th>
                                    <th class="px-4 py-2">Category</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Assigned To</th>
                                    <th class="px-4 py-2">Created At</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $ticket->subject }}</td>
                                        <td class="border px-4 py-2">{{ $ticket->category->name }}</td>
                                        <td class="border px-4 py-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $ticket->status->color }}-100 text-{{ $ticket->status->color }}-800">
                                                {{ $ticket->status->name }}
                                            </span>
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $ticket->assignedTo ? $ticket->assignedTo->name : '-' }}
                                        </td>
                                        <td class="border px-4 py-2">{{ $ticket->created_at->format('M d, Y') }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border px-4 py-2">No tickets found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>