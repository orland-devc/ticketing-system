@section('title', 'My Tickets')

@php
    use App\Enums\CategorySubjectEnum;
    $categories = CategorySubjectEnum::cases();
@endphp

<x-users-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Tickets') }} &nbsp;<ion-icon name="ticket" class="ml-2"></ion-icon>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 flex justify-between items-center flex-wrap">
                        <div class="flex space-x-4 select-none">
                            @foreach ([
                                'allTickets' => ['label' => 'All', 'count' => $allTickets, 'icon' => 'albums'],
                                // 'unread' => ['label' => 'Unread', 'count' => $unreadTicketsCount, 'icon' => 'mail-unread'],
                                'assigned' => ['label' => 'My Tickets', 'count' => $assignedTicketsCount, 'icon' => 'person'],
                                'closed' => ['label' => 'Closed', 'count' => $closedTicketsCount, 'icon' => 'checkmark-circle'],
                            ] as $id => $data)
                                    <a href="#" id="{{ $id }}" class="ticket-tab {{ $id === 'assigned' ? 'active' : 'inactive' }} flex items-center">
                                        <ion-icon name="{{ $data['icon'] }}" class="mr-2"></ion-icon>
                                    {{ $data['label'] }}
                                    
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <input type="text" id="ticket-search" placeholder="Search tickets..." class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 ease-in-out">
                        </div>
                    </div>
                    <div class="overflow-x-auto select-none">
                        <div class="bg-white overflow-y-auto overflow-x-hidden table-data" style="height: 70vh;">
                            @foreach ([ 'allTicketsbox' => $tickets, 'assignedbox' => $assignedTickets, 'closedbox' => $closedTickets ] as $boxId => $ticketList)
                            <div class="ticket-content {{ $boxId === 'assignedbox' ? '' : 'hidden' }}" id="{{ $boxId }}">
                                @forelse ($ticketList as $ticket)                             
                                        <a href="{{ route('user.tickets.show', $ticket->ticket_code) }}" 
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
                                            data-user-name="{{ $ticket->user->name }}"
                                            data-subject="{{ $ticket->subject }}"
                                            data-content="{{ $ticket->content }}"
                                            data-level="{{ $ticket->level }}">
                                            <div class="w-1/4 py-4 px-6 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if(empty($ticket->user->profile_picture))
                                                            <!-- Display user initials from ui-avatars if profile picture is empty -->
                                                            <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $ticket->user->name }}">
                                                        @else
                                                            <!-- Display user's actual profile picture if available -->
                                                            <img class="h-10 w-10 rounded-full" src="{{ asset($ticket->user->profile_picture) }}" alt="{{ $ticket->user->name }}">
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $ticket->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $ticket->ticket_code }}
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

    @if (Session::has('message'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ Session::get('message') }}', // Use the session message dynamically
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 px-4 py-2 rounded'
                }
            });
        </script>
    @endif


    <div class="fixed bottom-10 right-10">
        <div class="">
            <a href="#" onclick="showPostTab()" class="text-white">
                <div class="bg-blue-600 hover:bg-blue-500 shadow-md rounded-full p-6 flex flex-col justify-center items-center">
                    <ion-icon name="ticket" class="mb-2 text-4xl"></ion-icon>
                    <p class="text-sm font-semibold">Add Ticket</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Add Ticket Modal -->
    <div id="postTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none">
        <div id="postForm" class="w-full max-w-2xl mx-auto px-4">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold text-gray-800">Create New Ticket</h1>
                        <button onclick="hidePostTab()" class="text-gray-500 hover:text-red-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="text" name="sender_id" value="{{ Auth::user()->id }}" hidden>
                    
                        <div class="flex w-full gap-2">
                            <div class="flex-1">
                                <label for="level" class="text-sm font-medium text-gray-700 mb-2">Urgency Level</label>
                                <select id="ticketLevel" name="level" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4" required>
                                    <option value="normal">Normal</option>
                                    <option value="important">Important</option>     
                                    <option value="critical">Critical</option>                                   
                                </select>
                            </div>
                    
                            <div class="flex-1">
                                <label for="category" class="text-sm font-medium text-gray-700 mb-2">Category</label>
                                <div class="space-y-3">
                                    <select id="categoryDropdown" name="category" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4" required onchange="updateSubjects(); toggleOtherCategory(); updateAssignedOffice()">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->value }}" data-assign="{{ $category->getAssign() }}">{{ $category->getLabel() }}</option>
                                        @endforeach
                                        <option value="others">Others</option>
                                    </select>
                                    
                                    <input type="hidden" id="assignedOffice" name="assigned_office">
                                    
                                    <input type="text" id="otherCategory" name="other_category" class="hidden block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4" placeholder="Please specify category">
                                </div>
                            </div>
                        </div>
                    
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <div class="space-y-3">
                                <select id="subjectDropdown" name="subject" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4" required onchange="toggleOtherSubject()">
                                    <option value="">Select Subject</option>
                                    <!-- get CategorySubjectEnum::getSubjects() as subject options depending on selected category -->
                                    <option value="others">Others</option>
                                </select>
                                
                                <input type="text" id="otherSubject" name="other_subject" class="hidden block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4" placeholder="Please specify subject">
                            </div>
                        </div>
                    
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="content" name="content" rows="5" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4" required>{{ old('description') }}</textarea>
                        </div>
                    
                        <div>
                            <label for="attachments" class="block text-sm font-medium text-gray-700 mb-2">Attachments (optional)</label>
                            <div id="attachmentForm" class="flex items-center justify-center w-full">
                                <label class="flex flex-col rounded-lg border-4 border-dashed w-full h-60 p-10 group text-center">
                                    <div class="h-full w-full text-center flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-blue-400 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="lowercase text-sm text-gray-400 group-hover:text-blue-600 pt-1 tracking-wider">Select a photo</p>
                                    </div>
                                    <input type="file" id="attachments" name="attachments[]" class="hidden" multiple onchange="previewFiles(this.files)" accept="image/*">
                                </label>
                            </div>
                    
                            <div id="filePreview" class="mt-4 grid grid-cols-4 gap-4"></div>
                        </div>
                    
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                                Submit Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 

</x-users-layout>

<script>
    const categorySubjectMap = {
        @foreach($categories as $category)
            "{{ $category->value }}": {!! json_encode($category->getSubjects()) !!},
        @endforeach
    };

    function updateSubjects() {
        const category = document.getElementById('categoryDropdown').value;
        const subjectDropdown = document.getElementById('subjectDropdown');
        const otherSubjectInput = document.getElementById('otherSubject');

        const dropdown = document.getElementById('categoryDropdown');
        const hiddenInput = document.getElementById('assignedOffice');
        const selectedOption = dropdown.options[dropdown.selectedIndex];

        hiddenInput.value = selectedOption.dataset.assign || '';

        // Clear existing options
        subjectDropdown.innerHTML = '<option value="">Select Subject</option>';

        // Check if category exists in the map
        if (categorySubjectMap[category]) {
            // Populate subjects based on selected category
            categorySubjectMap[category].forEach(subject => {
                const option = document.createElement('option');
                option.value = subject;
                option.textContent = subject;
                subjectDropdown.appendChild(option);
            });
        }

        // Add "Others" option
        const otherOption = document.createElement('option');
        otherOption.value = 'others';
        otherOption.textContent = 'Others';
        subjectDropdown.appendChild(otherOption);

        // Hide other subject input initially
        otherSubjectInput.classList.add('hidden');
    }

    function toggleOtherSubject() {
        const subjectDropdown = document.getElementById('subjectDropdown');
        const otherSubjectInput = document.getElementById('otherSubject');

        if (subjectDropdown.value === 'others') {
            otherSubjectInput.classList.remove('hidden');
        } else {
            otherSubjectInput.classList.add('hidden');
        }
    }
</script>

<style>
    .scrollBars::-webkit-scrollbar {
        width: 5px; /* Set the width of the scrollbar */
    }

    /* Modify the scrollbar thumb (the draggable handle) */
    .scrollBars::-webkit-scrollbar-thumb {
        background-color: #3b82f6; /* Set the color of the thumb */
        border-radius: 5px; /* Set the border radius of the thumb */
    }



</style>

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

    function toggleOtherCategory() {
        const categoryDropdown = document.getElementById('categoryDropdown');
        const otherCategoryInput = document.getElementById('otherCategory');
        
        if (categoryDropdown.value === 'others') {
            otherCategoryInput.classList.remove('hidden');
            otherCategoryInput.required = true;
        } else {
            otherCategoryInput.classList.add('hidden');
            otherCategoryInput.required = false;
            otherCategoryInput.value = ''; // Clear the input when hidden
        }
    }

    function toggleOtherSubject() {
        const subjectDropdown = document.getElementById('subjectDropdown');
        const otherSubjectInput = document.getElementById('otherSubject');
        
        if (subjectDropdown.value === 'others') {
            otherSubjectInput.classList.remove('hidden');
            otherSubjectInput.required = true;
        } else {
            otherSubjectInput.classList.add('hidden');
            otherSubjectInput.required = false;
            otherSubjectInput.value = ''; // Clear the input when hidden
        }
    }

    const tabs = document.querySelectorAll('#myTab button');
    const tabContents = document.querySelectorAll('#myTabContent > div');

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            tabs.forEach(tab => tab.classList.remove('text-blue-600', 'border-blue-600'));
            tabContents.forEach(content => content.classList.add('hidden'));

            tab.classList.add('text-blue-600', 'border-blue-600');
            tabContents[index].classList.remove('hidden');
        });
    });


    function showPostTab() {
        const postTab = document.getElementById('postTab');
        const postForm = document.getElementById('postForm');
        postTab.style.display = 'flex';
        postTab.classList.add('animated-show');
        postForm.classList.add('animated-pulse');
    }

    function hidePostTab() {
        const postTab = document.getElementById('postTab');
        const postForm = document.getElementById('postForm');
        postTab.classList.add('animated-vanish');
        postForm.classList.add('animated-close');

        setTimeout(() => {
            postTab.style.display = 'none';
            postTab.classList.remove('animated-pulse');
            postForm.classList.remove('animated-close');
            postTab.classList.remove('animated-vanish');
        }, 300);
    }

    document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' || event.keyCode === 27) {
                hidePostTab();
                hideimageTab();
            }
        });
        
</script>

<script>
    let selectedFiles = [];

    function previewFiles(files) {
        const attachmentForm = document.getElementById('attachmentForm');
        const filePreview = document.getElementById('filePreview');

        filePreview.innerHTML = '';
        if (files.length == 0) {
            attachmentForm.style.display = 'block';
        } else if (files.length > 0) {
            attachmentForm.style.display = 'none';
        }

        selectedFiles = [...selectedFiles, ...files];

        if (selectedFiles.length === 0) {
            return;
        }

        selectedFiles.forEach((file) => {
            const reader = new FileReader();

            reader.addEventListener('load', () => {
                const imgPreview = document.createElement('div');
                imgPreview.classList.add('m-2', 'relative', 'inline-block');

                const img = document.createElement('img');
                img.src = reader.result;
                img.classList.add('max-h-32', 'object-contain', 'rounded-lg', 'border', 'border-blue-800');

                const removeBtn = document.createElement('button');
                removeBtn.classList.add('transform', 'translate-x-2', '-translate-y-2', 'absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'w-6', 'h-6', 'flex', 'items-center', 'justify-center', 'focus:outline-none', 'hover:bg-red-600', 'transition-colors', 'duration-200');
                removeBtn.innerHTML = '&times;';
                removeBtn.addEventListener('click', () => {
                    imgPreview.remove();
                    selectedFiles = selectedFiles.filter(f => f !== file);
                });

                imgPreview.appendChild(img);
                imgPreview.appendChild(removeBtn);
                filePreview.appendChild(imgPreview);
            });

            reader.readAsDataURL(file);
        });
    }

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.clickable').click(function() {
            var url = $(this).attr('href');
            if (url) {
                window.location.href = url;
            }
        });

        $('.ticket-tab').click(function(e) {
            e.preventDefault();
            var targetId = $(this).attr('id') + 'box';
            $('.ticket-tab').removeClass('active').addClass('inactive');
            $(this).removeClass('inactive').addClass('active');
            $('.ticket-content').addClass('hidden');
            $('#' + targetId).removeClass('hidden');
            $('#ticket-search').val(''); // Clear search input when changing tabs
            filterTickets(''); // Show all tickets in the new tab
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
    .ticket-tab {
        color: #6b7280;
        border-bottom-width: 2px;
        border-bottom-color: transparent;
        padding: 0.5rem 1rem;
    }

    .ticket-tab:hover {
        color: #4b5563;
    }

    .ticket-tab.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
        font-weight: 600;
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