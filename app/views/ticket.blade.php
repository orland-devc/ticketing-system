@section('title', 'Ticket Management')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Tickets') }} &nbsp; <ion-icon name="ticket"></ion-icon>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-10">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('tickets.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Create Ticket
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="bg-white shadow-md rounded-lg py-6 border" style="overflow-y: scroll; overflow: hidden;">
                            <table  class="w-full">
                                @forelse ($tickets as $ticket)
                                <tr class="clickable-row" data-url="{{ route('ticket.show', ['ticket' => $ticket->id]) }}">
                                    @php
                                            $partialContent = Str::limit($ticket->content, 70, '...');
                                        @endphp
                                        <td class="none px-5"><input type="checkbox"></td>
                                        <td class="py-5 pr-20 none">{{ $ticket->user->name }}</td>
                                        <td class="none">{{ $ticket->subject }} — {{ $partialContent }}</td>
                                        <td class="text-xs text-gray-500 none">{{ $ticket->created_at->diffForHumans() }}</td>
                                        
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No tickets found.</td>
                                    </tr>
                                @endforelse
                            </table>
                            
                            @forelse ($tickets as $ticket)
                                @php
                                    $partialContent = Str::limit($ticket->content, 70, '...');
                                @endphp
                                <ul>
                                    <li class="mb-2 mt-2">
                                        <div class="flex justify-between items-center">
                                            <div class="grid grid-cols-2 gap-6">
                                                <p class="flex text-gray-500">{{$ticket->user->name}}</p>
                                                <p class="flex text-gray-500">{{ $ticket->subject }} — {{$partialContent}}</p>
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }}</div>
                                        </div>
                                    </li>
                                    <hr>
                                </ul>

                            </tbody>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{-- {{ $tickets->links() }} --}}
                    </div>

                </div>
            </div>

            <!--  View -->
            <div>
                <!-- view all details of the ticket -->
            </div>

        </div>
        
    </div>
</x-app-layout>

<script>
    function showTicketDetails(ticketId) {
        var detailsRow = document.getElementById(`ticket-details-${ticketId}`);
        detailsRow.classList.toggle('hidden');
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.clickable-row').click(function() {
            var url = $(this).data('url');
            if (url) {
                window.location.href = url;
            }
        });
    });
</script>

<style>
    .none {
        border: none;
        border-bottom: 1px solid #c8c8c8;
    }
    .clickable-row:hover {
        cursor: pointer;
        background-color: rgb(225, 225, 225);
    }
</style>