@section('title', 'Ticket Management')
<x-office-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Assigned Tickets
        </h2>
    </x-slot>

    <div class="py-6">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 flex justify-between items-center flex-wrap">
                        <div class="flex space-x-4 select-none">
                            <div class="ticket-tab-container">
                                <div class="ticket-tab-slider"></div>
                                @foreach ([
                                    'allTickets' => ['label' => 'All', 'count' => $dumpsCount, 'icon' => 'albums'],
                                    'unread' => ['label' => 'Open', 'count' => $assignedTicketsCount, 'icon' => 'mail-unread'],
                                    'closed' => ['label' => 'Closed', 'count' => $closedTicketsCount, 'icon' => 'checkmark-circle'],
                                ] as $id => $data)
                                    <a href="#" id="{{ $id }}" class="ticket-tab {{ $id === 'unread' ? 'active' : 'inactive' }} flex items-center">
                                        <ion-icon name="{{ $data['icon'] }}" class="mr-2"></ion-icon>
                                        {{ $data['label'] }}
                                        @if ($data['count'] > 0)
                                            <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full ml-2">
                                                {{ $data['count'] }}
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <input type="text" id="ticket-search" placeholder="Search tickets..." class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 ease-in-out">
                        </div>
                    </div>
                    <div class="overflow-x-auto select-none">
                        <div class="bg-white overflow-y-auto overflow-x-hidden table-data" style="height: 70vh;">
                            @foreach ([ 'allTicketsbox' => $dumps, 'unreadbox' => $assignedTickets, 'closedbox' => $closedTickets ] as $boxId => $ticketList)
                                <div class="ticket-content {{ $boxId === 'unreadbox' ? '' : 'hidden' }}" id="{{ $boxId }}">
                                    @forelse ($ticketList as $ticket)                             
                                        <a href="{{ route('office.tickets.show', ['ticket' => $ticket->id]) }}" 
                                            class="clickable border-l-8 border-t 
                                            @if ($ticket->level == "normal")
                                               border-green-400
                                            @elseif ($ticket->level == "important")
                                                border-yellow-400
                                            @elseif ($ticket->level == "critical")
                                                border-red-400 
                                            @endif
                                            my-4 flex items-center justify-between rounded-l-lg"
                                            data-ticket-id="{{ $ticket->id }}"
                                            data-user-name="{{ $ticket->user->name ?? $ticket->guest_name }}"
                                            data-subject="{{ $ticket->subject }}"
                                            data-content="{{ $ticket->content }}"
                                            data-level="{{ $ticket->level }}">
                                            <div class="w-1/4 py-4 px-6 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if(isset($ticket->user) && empty($ticket->user->profile_picture))
                                                            <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $ticket->user->name }}" style="border: 1px solid blue">
                                                        @elseif(isset($ticket->user))
                                                            <img class="h-10 w-10 rounded-full" src="{{ asset($ticket->user->profile_picture) }}" alt="{{ $ticket->user->name }}">
                                                        @else
                                                            <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($ticket->guest_name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $ticket->guest_name }}" style="border: 1px solid blue">
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $ticket->user->name ?? $ticket->guest_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            ID {{ $ticket->id }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-1/2 py-4 px-6">
                                                <div class="text-sm text-gray-900 font-medium">{{ $ticket->subject }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($ticket->content, 50, ' . . .') }}</div>
                                            </div>
                                            <div class="w-1/4 py-4 px-6 whitespace-nowrap text-right text-sm font-medium">
                                                <span class="text-gray-500">{{ $ticket->created_at->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                        @empty
                                        <div class="no-results">
                                            <div class="p-10 text-center">
                                                <img src="{{ asset('images/bot.png') }}" width="200" alt="No tickets" class="opacity-50 mx-auto mb-4">
                                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                    No {{ isset($loop->parent) && $loop->parent->first ? 'unread' : '' }} tickets found.
                                                </h2>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-office-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const $slider = $('.ticket-tab-slider');

        function moveSlider($activeTab) {
            const left = $activeTab.position().left;
            const width = $activeTab.outerWidth();
            $slider.css({
                left: left,
                width: width
            });
        }

        const $initialActiveTab = $('.ticket-tab.active');
        moveSlider($initialActiveTab);

        $('.ticket-tab').click(function(e) {
            e.preventDefault();
            const $clickedTab = $(this);
            var targetId = $(this).attr('id') + 'box';
            $('.ticket-tab').removeClass('active');
            $clickedTab.addClass('active');
            const $slider = $('.ticket-tab-slider');
            const left = $clickedTab.position().left || 0; // Ensure a default value in case of calculation issues
            const width = $clickedTab.outerWidth() || 0;  // Ensure a default value in case of calculation issues
            if (width > 0) { // Only apply changes if valid width is detected
                $slider.css({
                    left: left,
                    width: width,
                });
            }
            $(this).removeClass('inactive').addClass('active');
            $('.ticket-content').addClass('hidden');
            $('#' + targetId).removeClass('hidden');
            $('#ticket-search').val(''); // Clear search input when changing tabs
            filterTickets(''); // Show all tickets in the new tab
            moveSlider($clickedTab);

        });

        


        $('.clickable').click(function() {
            var url = $(this).attr('href');
            if (url) {
                window.location.href = url;
            }
        });

        $('#ticket-search').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            filterTickets(searchTerm);
        });

        function filterTickets(searchTerm) {
            var activeTab = $('.ticket-tab.active').attr('id') + 'box';
            var visibleRows = 0;

            $('#' + activeTab + ' .clickable').each(function() {
                var row = $(this);
                var ticketId = row.data('ticket-id').toString();
                var userName = row.data('user-name').toLowerCase();
                var subject = row.data('subject').toLowerCase();
                var content = row.data('content').toLowerCase();

                // Remove existing highlights
                row.find('.highlight').contents().unwrap();

                if (ticketId.includes(searchTerm) || userName.includes(searchTerm) || 
                    subject.includes(searchTerm) || content.includes(searchTerm)) {
                    row.removeClass('hidden');
                    visibleRows++;
                    
                    // Highlight matching text
                    highlightText(row.find('.text-sm'), searchTerm);
                } else {
                    row.addClass('hidden');
                }
            });

            // Show or hide the "No results" message
            if (visibleRows === 0) {
                $('#' + activeTab + ' .no-results').removeClass('hidden');
            } else {
                $('#' + activeTab + ' .no-results').addClass('hidden');
            }
        }

        function highlightText(elements, searchTerm) {
            elements.each(function() {
                var element = $(this);
                var text = element.text();
                var regex = new RegExp('(' + escapeRegExp(searchTerm) + ')', 'gi');
                var newText = text.replace(regex, '<span class="highlight">$1</span>');
                element.html(newText);
            });
        }

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }
    });
</script>

<style>
    .ticket-tab-container {
        position: relative;
        display: flex;
        justify-content: start;
        border-bottom: 2xpx solid #fff; /* Light gray border to define the tab area */
    }

    .ticket-tab {
        position: relative;
        color: #6b7280;
        padding: 0.5rem 1rem;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .ticket-tab:hover {
        color: #4b5563;
    }

    .ticket-tab.active {
        color: #2563eb;
        font-weight: 600;
    }

    .ticket-tab-slider {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        width: 0;
        background-color: #2563eb;
        transition: all 0.3s ease;
    }

    .clickable {
        transition: all 0.2s ease-in-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .clickable:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .table-data::-webkit-scrollbar {
        width: 6px;
    }
    .table-data::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .table-data::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    .table-data::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .highlight {
        background-color: yellow;
        font-weight: bold;
    }
</style>
