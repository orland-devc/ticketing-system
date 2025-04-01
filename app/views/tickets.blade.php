@section('title', 'Ticket Management')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Tickets') }} &nbsp; <ion-icon name="ticket"></ion-icon>
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-screen px-4">
            <div class="bg-white overflow-hidden pt-3">
                <div class="text-gray-900">
                    <div class="mb-4">
                        <a href="#" id="allTickets" class="inactive">
                            All
                            @if ($all_tickets == 0)
                            @else
                                <span class="bg-gray-300 text-black px-2 rounded-full ml-2">{{ $all_tickets }}</span>
                            @endif
                        </a>

                        <a href="#" id="unread" class="active">
                            Unread
                            @if ($unreadTicketsCount == 0)
                            @else
                                <span class="bg-red-500 text-white px-2 rounded-full ml-2">{{ $unreadTicketsCount }}</span>
                            @endif
                        </a>

                        <a href="#" id="assigned" class="inactive">
                            Assigned
                            @if ($unreadTicketsCount == 0)
                            @else
                            <span class="bg-gray-300 text-black px-2 rounded-full ml-2">{{ $open_tickets }}</span>


                            @endif
                        </a>
                        <a href="#" id="closed" class="inactive">
                            Closed
                            @if ($unreadTicketsCount == 0)
                            @else
                                <span class="bg-gray-300 text-black px-2 rounded-full ml-2">{{ $closed_tickets }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="bg-white shadow-md rounded-lg py-6" style="overflow-y: scroll; overflow: hidden;">
                            <table class="w-full">
                                <tbody id="allbox" class="hidden">
                                    @forelse ($tickets as $ticket)
                                    <tr class="clickable-row" data-url="{{ route('ticket.show', ['ticket' => $ticket->id]) }}">
                                        @php
                                            $partialContent = Str::limit($ticket->content, 80, ' . . .');
                                        @endphp
                                        <td class="py-4 px-5 none" style="width: 5px;"><input type="checkbox"></td>
                                        <td class="px-1 font-bold none" style="width: 100px">ID {{ $ticket->id }}</td>
                                        <td class="px-1 font-bold none pr-5" style="max-width: 300px">{{ $ticket->user->name }}</td>
                                        <td class="none" style="width: 900px">{{ $ticket->subject }} — {{ $partialContent }}</td>
                                        <td class="text-xs text-gray-500 none" style="max-width: 100px">{{ $ticket->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-5 text-center border border-white pointer-events-none select-none">
                                            <img src="{{ asset('images/bot.png') }}" width="420" alt="" class="opacity-80 mx-auto mb-5 pl-10">
                                            <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
                                                No unread tickets right now.
                                            </h2>
                                            <p class="text-center text-xl text-gray-800"></p>
                                        </td></tr>
                                    @endforelse
                                </tbody>

                                <tbody id="unreadbox">
                                    @forelse ($unreadTickets as $ticket)
                                    <tr class="clickable-row" data-url="{{ route('ticket.show', ['ticket' => $ticket->id]) }}">
                                        @php
                                            $partialContent = Str::limit($ticket->content, 80, ' . . .');
                                        @endphp
                                        <td class="py-4 px-5 none" style="width: 5px;"><input type="checkbox"></td>
                                        <td class="px-1 font-bold none" style="width: 100px">ID {{ $ticket->id }}</td>
                                        <td class="px-1 font-bold none pr-5" style="max-width: 300px">{{ $ticket->user->name }}</td>
                                        <td class="none" style="width: 900px">{{ $ticket->subject }} — {{ $partialContent }}</td>
                                        <td class="text-xs text-gray-500 none" style="max-width: 100px">{{ $ticket->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-5 text-center border border-white pointer-events-none select-none">
                                            <img src="{{ asset('images/bot.png') }}" width="420" alt="" class="opacity-80 mx-auto mb-5 pl-10">
                                            <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
                                                No unread tickets right now.
                                            </h2>
                                            <p class="text-center text-xl text-gray-800"></p>
                                        </td></tr>
                                    @endforelse
                                </tbody>

                                <tbody id="assignedbox" class="hidden">
                                    @forelse ($assignedTickets as $ticket)
                                        <tr class="clickable-row" data-url="{{ route('ticket.show', ['ticket' => $ticket->id]) }}">
                                            @php
                                                $partialContent = Str::limit($ticket->content, 80, ' . . .');
                                            @endphp
                                            <td class="py-4 px-5 none" style="width: 5px;"><input type="checkbox"></td>
                                            <td class="px-1 font-bold none" style="width: 100px">ID {{ $ticket->id }}</td>
                                            <td class="px-1 font-bold none pr-5" style="max-width: 300px">{{ $ticket->user->name }}</td>
                                            <td class="none" style="width: 900px">{{ $ticket->subject }} — {{ $partialContent }}</td>
                                            <td class="text-xs text-gray-500 none" style="max-width: 100px">{{ $ticket->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 none">No tickets found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <tbody id="closedbox" class="hidden">
                                    @forelse ($closedTickets as $ticket)
                                        <tr class="clickable-row" data-url="{{ route('ticket.show', ['ticket' => $ticket->id]) }}">
                                            @php
                                                $partialContent = Str::limit($ticket->content, 80, ' . . .');
                                            @endphp
                                            <td class="py-4 px-5 none" style="width: 5px;"><input type="checkbox"></td>
                                            <td class="px-1 font-bold none" style="width: 100px">ID {{ $ticket->id }}</td>
                                            <td class="px-1 font-bold none pr-5" style="max-width: 300px">{{ $ticket->user->name }}</td>
                                            <td class="none" style="width: 900px">{{ $ticket->subject }} — {{ $partialContent }}</td>
                                            <td class="text-xs text-gray-500 none" style="max-width: 100px">{{ $ticket->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 none">No tickets found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var allTickets = document.getElementById('allTickets');
        var unread = document.getElementById("unread");
        var assigned = document.getElementById("assigned");
        var closed = document.getElementById("closed");

        var allbox = document.getElementById("allbox");
        var unreadbox = document.getElementById("unreadbox");
        var assignedbox = document.getElementById("assignedbox");
        var closedbox = document.getElementById("closedbox");

        allTickets.addEventListener("click", function() {
            allbox.classList.remove('hidden');
            unreadbox.classList.add("hidden");
            assignedbox.classList.add("hidden");
            closedbox.classList.add("hidden");

            allTickets.classList.add("active");
            allTickets.classList.remove("inactive");
            unread.classList.add("inactive");
            unread.classList.remove("active");
            assigned.classList.remove("active");
            assigned.classList.add("inactive");
            closed.classList.remove("active");
            closed.classList.add("inactive");
        });
            
        unread.addEventListener("click", function() {
            allbox.classList.add('hidden');
            unreadbox.classList.remove("hidden");
            assignedbox.classList.add("hidden");
            closedbox.classList.add("hidden");

            allTickets.classList.remove("active");
            allTickets.classList.add("inactive");
            unread.classList.remove("inactive");
            unread.classList.add("active");
            assigned.classList.remove("active");
            assigned.classList.add("inactive");
            closed.classList.remove("active");
            closed.classList.add("inactive");
        });

        assigned.addEventListener("click", function() {
            allbox.classList.add('hidden');
            unreadbox.classList.add("hidden");
            assignedbox.classList.remove("hidden");
            closedbox.classList.add("hidden");

            allTickets.classList.remove("active");
            allTickets.classList.add("inactive");
            unread.classList.add("inactive");
            unread.classList.remove("active");
            assigned.classList.add("active");
            assigned.classList.remove("inactive");
            closed.classList.remove("active");
            closed.classList.add("inactive");
        });
        
        closed.addEventListener("click", function() {
            allbox.classList.add('hidden');
            unreadbox.classList.add("hidden");
            assignedbox.classList.add("hidden");
            closedbox.classList.remove("hidden");

            allTickets.classList.remove("active");
            allTickets.classList.add("inactive");
            unread.classList.add("inactive");
            unread.classList.remove("active");
            assigned.classList.remove("active");
            assigned.classList.add("inactive");
            closed.classList.add("active");
            closed.classList.remove("inactive");
        });
    });
</script>


<style>
    .active {
    color: #3c3c3c; /* text-gray-700 */
    border-bottom-width: 3px; /* border-b-2 */
    border-bottom-color: #2b6cb0; /* border-blue-800 */
    font-weight: bold; /* font-bold */
    padding: 0.3rem 0; /* py-2 */
    margin: 0 0.5rem;
    }
    .inactive {
    color: #6b7280; /* text-gray-500 */
    border-bottom-width: 2px; /* border-b-2 */
    border-bottom-color: #fff; /* border-white */
    padding: 0.3rem 0; /* py-2 */
    margin: 0 0.5rem;
    }

    .inactive:hover {
        color: #484848;
        border-bottom-color: #ccc; /* border-white */
    }
</style>