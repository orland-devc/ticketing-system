@section('title', 'My Tickets')

<x-users-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Tickets') }} &nbsp;<ion-icon name="ticket-outline" class="ml-2"></ion-icon>
        </h2>
    </x-slot>

    <div class="">
        <div class="">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 text-blue-600 hover:text-blue-600 border-blue-600" id="all-tickets-tab" data-tabs-target="#all-tickets" type="button" role="tab" aria-controls="all-tickets" aria-selected="true">All Tickets</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="sent-tickets-tab" data-tabs-target="#sent-tickets" type="button" role="tab" aria-controls="sent-tickets" aria-selected="false">Sent Tickets</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="closed-tickets-tab" data-tabs-target="#closed-tickets" type="button" role="tab" aria-controls="closed-tickets" aria-selected="false">Closed Tickets</button>
                            </li>
                        </ul>
                    </div>
                    <div id="">
                        <div class="p-4 rounded-lg bg-gray-50" id="all-tickets" role="tabpanel" aria-labelledby="all-tickets-tab">
                            <table>
                                <tbody id="allbox" class="">
                                    @forelse ($allTickets as $ticket)
                                    <tr class="clickable-row" data-url="{{ route('user.tickets.show', $ticket->id) }}">
                                        @php
                                            $partialContent = Str::limit($ticket->content, 100, ' . . .');
                                        @endphp
                                        <td class="py-4 px-5 none" style="width: 5px;"><input type="checkbox"></td>
                                        <td class="px-1 font-bold none" style="width: 100px">ID {{ $ticket->id }}</td>
                                        <td class="px-1 pl-5 font-bold  pr-5 none" style="max-width: 300px">{{ $ticket->user->name }}</td>
                                        <td class="pl-5 none" style="width: 1100px">{{ $ticket->subject }} — {{ $partialContent }}</td>
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
                            </table>
                            <livewire:tickets-table :type="'all'" />
                        </div>
                        <div class="hidden p-4 rounded-lg bg-gray-50" id="sent-tickets" role="tabpanel" aria-labelledby="sent-tickets-tab">
                            <!-- Sent Tickets Table -->
                            <livewire:tickets-table :type="'sent'" />
                        </div>
                        <div class="hidden p-4 rounded-lg bg-gray-50" id="closed-tickets" role="tabpanel" aria-labelledby="closed-tickets-tab">
                            <!-- Closed Tickets Table -->
                            <livewire:tickets-table :type="'closed'" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="absolute bottom-10 right-10">
            <a href="#" onclick="showPostTab()" class="text-white">
                <div class="bg-blue-600 hover:bg-blue-500 shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                    <i class="fas fa-plus-circle fa-3x mb-2 my-auto"></i>
                    <p class="text-sm font-semibold">Create Ticket</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Add Ticket Modal -->
    <div id="postTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
        <div id="postForm" class="max-w-full mx-auto sm:px-6 lg:px-8" style="width: 800px">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900 max-h-[80vh] overflow-y-auto scrollBars">
                    <h1 class="text-2xl font-semibold text-gray-700 mb-4">Create New Ticket</h1>
                    <a href="#" onclick="hidePostTab()" class="text-5xl hover:text-red-500 px-4 py-0 absolute" style="transform:  translate(1150%, -130%); border-radius: 0 8px 0 0">&times;</a>
                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <input type="text" name="sender_id" value="{{ Auth::user()->id }}" hidden>

                            <div>
                                <label for="subject" class="block text-gray-700 font-semibold mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="shadow appearance-none border rounded-lg w-full py-4 px-6 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" required>
                                @error('subject')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
                                <div class="relative">
                                    <select id="ticketCategory" name="category" class="shadow appearance-none border rounded-lg w-full py-4 px-6 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" required>
                                        <option value="">Select Category</option>
                                        <option value="Admissions">Admissions</option>
                                        <option value="Academic Affairs">Academic Affairs</option>
                                        <option value="Financial Aid">Financial Aid</option>
                                        <option value="Scholarships">Scholarships</option>
                                        <option value="IT Support">IT Support</option>
                                        <option value="Student Services">Student Services</option>
                                        <option value="Faculty/Staff Support">Faculty/Staff Support</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Feedback/Suggestions">Feedback/Suggestions</option>
                                    </select>
                                </div>
                                @error('category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="content" class="block text-gray-700 font-semibold mb-2">Description</label>
                                <textarea id="content" name="content" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="attachments" class="block text-gray-700 font-semibold mb-2">Attachments (optional)</label>
                                <div class="flex items-center justify-center bg-gray-100 rounded-lg py-4">
                                    <label for="attachments" class="flex flex-col items-center justify-center cursor-pointer">
                                        <div class="flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full mb-2 transition-colors duration-200 hover:bg-blue-600">
                                            <ion-icon name="attach-outline" class="text-2xl"></ion-icon>
                                        </div>
                                        <span class="text-sm text-gray-700">Click to upload files</span>
                                    </label>
                                    <input type="file" id="attachments" name="attachments[]" class="hidden" multiple onchange="previewFiles(this.files)" accept="image/*">
                                </div>
                                <div id="filePreview" class="mt-4"></div>
                                @error('attachments')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Submit Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    

</x-users-layout>

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
        const filePreview = document.getElementById('filePreview');
        filePreview.innerHTML = '';

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