@section('title', 'Office Head Dashboard')

<x-office-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Office Head Dashboard
            </h2>
            {{-- <a href="{{ route('my-tickets') }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded focus:outline-none focus:shadow-outline">
                <ion-icon name="add-circle" class="mr-2"></ion-icon>
                New Ticket
            </a> --}}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-blue-200 overflow-hidden shadow-md rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Total Tickets</h3>
                            <ion-icon name="ticket" class="text-3xl text-blue-500"></ion-icon>
                        </div>
                        {{-- <h2 class="text-4xl font-bold text-gray-800">{{ $totalTickets }}</h2> --}}
                        <h2 class="text-4xl font-bold text-gray-800">{{$assignedTickets->count()}}</h2>
                    </div>
                </div>

                <div class="bg-yellow-200 overflow-hidden shadow-md rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Open Tickets</h3>
                            <ion-icon name="alert-circle" class="text-3xl text-yellow-500"></ion-icon>
                        </div>
                        {{-- <h2 class="text-4xl font-bold text-gray-800">{{ $openTickets }}</h2> --}}
                        <h2 class="text-4xl font-bold text-gray-800">{{$assignedTickets->where('status', 'open')->count()}}</h2>
                    </div>
                </div>

                <div class="bg-green-200 overflow-hidden shadow-md rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Resolved Tickets</h3>
                            <ion-icon name="checkmark-circle" class="text-3xl text-green-500"></ion-icon>
                        </div>
                        {{-- <h2 class="text-4xl font-bold text-gray-800">{{ $resolvedTickets }}</h2> --}}
                        <h2 class="text-4xl font-bold text-gray-800">{{$assignedTickets->where('status', 'closed')->count()}}</h2>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Tickets</h3>
                <div class="bg-white overflow-hidden shadow-md rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-400">
                                <tr class="">
                                    <th scope="col" class="bg-gray-800 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="bg-gray-800 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Subject
                                    </th>
                                    <th scope="col" class="bg-gray-800 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th scope="col" class="bg-gray-800 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Urgency
                                    </th>
                                    <th scope="col" class="bg-gray-800 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Assigned To
                                    </th>
                                    <th scope="col" class="bg-gray-800 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Created At
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($assignedTicketss as $ticket)
                                <tr onclick="window.location='{{ route('office.tickets.show', $ticket->id) }}';" class="cursor-pointer hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $ticket->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $ticket->subject }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $ticket->category }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $ticket->status === 'open' ? 'green' : 'red' }}-100 text-{{ $ticket->status === 'open' ? 'green' : 'red' }}-800"> --}}
                                        <div class="text-sm font-medium text-gray-900">
                                                {{ $ticket->level }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $ticket->ticket ? $ticket->ticket->name : '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ticket->created_at->format('M d, Y h:i A') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No assigned tickets found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-office-layout>

