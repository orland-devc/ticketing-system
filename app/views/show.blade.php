@section('title', 'Ticket ID ' . $ticket->id)


<x-app-layout>
    <x-slot name="header">
        <a href="http://127.0.0.1:8000/tickets" class="absolute text-xl top-4 ml-2" style="transform:translateX(-100%)">
            <ion-icon name="arrow-back-outline" class=""></ion-icon>
        </a>
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-5 mb-2">
                Ticket ID {{ $ticket->id }}&nbsp; <ion-icon name="ticket" class="opacity-0"></ion-icon>
            </h2>
            <span class="ml-5 mt-2 text-sm text-gray-400">{{ $ticket->created_at->format('M d, Y g:i A') }}</span>
            <div class="ml-5">
                @include('_updates')
            </div>
        </div>
    </x-slot>

    <div class="max-w-screen flex p-3 bg-gray-100">
        <div class="bg-white border border-2 shadow-lg rounded-lg mr-2 w-1/4 min-w-72 border">
            <div class="flex items-center text-2xl m-auto p-4">
                <ion-icon name="ticket" class="mr-2 text-gray-400" style="margin-top: -5px;"></ion-icon>
                <h2 class="text-xl font-semibold text-gray-800 text-center">
                    Ticket Form Details
                </h2>
            </div>
            <hr class="border">
            {{-- <div class="p-4 bg-gray-100 rounded-t-lg flex justify-between items-center top-options">
                <div class="flex items-center space-x-2">
                    @if ($ticket->status == 'closed')
                    @else
                        <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                            @csrf
                            @method('PUT')
                            <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded mr-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <ion-icon name="close-circle-outline" class="mr-2"></ion-icon>
                                Close Ticket
                            </button>
                            <button class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <ion-icon name="checkmark-circle-outline" class="mr-2"></ion-icon>
                                Resolve Ticket
                            </button>
                        </form>
                    @endif
                </div>
            </div> --}}
            <style>
                .ticket-content {
                    scrollbar-width: thin; /* "auto" hides scrollbar in Firefox */
                    scrollbar-color: #4a5568 #edf2f7; /* thumb color and track color */
                }

                .ticket-content::-webkit-scrollbar {
                    width: 12px; /* width of the scrollbar */
                }

                /* Customize the scrollbar thumb */
                .ticket-content::-webkit-scrollbar-thumb {
                    background-color: #667896; /* color of the thumb */
                    border-radius: 6px; /* rounded corners */
                }

                /* Change scrollbar thumb on hover */
                .ticket-content::-webkit-scrollbar-thumb:hover {
                    background-color: #2d3748; /* darker color on hover */
                }

                /* Customize the scrollbar track (optional) */
                .ticket-content::-webkit-scrollbar-track {
                    background-color: #edf2f7; /* color of the track */
                }
            </style>

            <div class="py-4 px-6 overflow-y-auto ticket-content" style="max-height: 70vh">
                <div class="mb-4">                    
                    <h3 class="text-xl font-semibold text-gray-800">{{ $ticket->category }}</h3>
                    <p class="text-gray-400">{{ $ticket->user->name }}</p>
                    <span class="mt-2 text-sm text-gray-400">{{ $ticket->created_at->format('M d, Y g:i A') }}</span>
                </div>
                
                <hr style="border: 1px dashed #ccc;">

                <div class="mb-6">
                    <div class="flex items-center my-3">
                        {{-- <ion-icon name="document-text-outline" class="text-3xl text-blue-500 mr-4"></ion-icon> --}}
                        <h4 class="text-lg font-semibold text-gray-800">{{ $ticket->subject }}</h4>
                    </div>
                    @php
                        $partialContent = Str::limit($ticket->content, 70, ' . . .');
                    @endphp

                    <div class="mb-4">
                        <p class="text-gray-600" id="partialContent">{{ $partialContent }}</p>
                        <p class="text-gray-600 hidden" id="fullContent">{{ $ticket->content }}</p>
                        <a href="#" id="readMore" class="text-blue-500 flex items-center mt-0 font-semibold">
                            Read more &nbsp;
                            <ion-icon name="arrow-forward"></ion-icon>
                        </a>

                        <a href="#" id="readLess" class="text-blue-500 flex items-center mt-0 font-semibold hidden">
                            Read less &nbsp;
                            <ion-icon name="arrow-back"></ion-icon>
                        </a>
                    </div>

                    <style>
                        .reveal {
                            animation: slideDown 0.3s ease-in-out;
                        }
                        @keyframes slideDown {
                            0% {
                                max-height: 0;
                                opacity: 0;
                            }
                            100% {
                                max-height: 500px; /* Set to a larger value than the expected full content height */
                                opacity: 1;
                            }
                        }

                        .hideUp {
                            animation: slideUp 0.3s ease-in-out;
                        }
                        @keyframes slideUp {
                            0% {
                                max-height: 500px;
                                opacity: 0;
                            }
                            100% {
                                max-height: 0; /* Set to a larger value than the expected full content height */
                                opacity: 1;
                            }
                        }
                    </style>

                    <script>
                        document.getElementById('readMore').addEventListener('click', function(event) {
                            event.preventDefault();
                            document.getElementById('partialContent').classList.add('hidden');
                            document.getElementById('fullContent').classList.remove('hidden');
                            document.getElementById('fullContent').classList.remove('hideUp');
                            setTimeout(function() {
                                document.getElementById('fullContent').classList.add('reveal');
                            }, 10); // Delay the addition of the 'reveal' class
                            document.getElementById('readMore').classList.add('hidden');
                            document.getElementById('readLess').classList.remove('hidden');
                        });

                        document.getElementById('readLess').addEventListener('click', function(event) {
                            event.preventDefault();
                            document.getElementById('partialContent').classList.remove('hidden');
                            document.getElementById('fullContent').classList.add('hidden');
                            document.getElementById('fullContent').classList.remove('reveal');
                            setTimeout(function() {
                                document.getElementById('fullContent').classList.add('hideUp');
                            }, 10); // Delay the addition of the 'reveal' class
                            document.getElementById('readMore').classList.remove('hidden');
                            document.getElementById('readLess').classList.add('hidden');
                        });
                    </script>



                    

                    @if ($ticket->attachments->isNotEmpty())
                        <div class="mb-6">
                            @foreach ($ticket->attachments as $attachment)
                            @php
                                $maxLength = 20;
                                $partialFileName = Str::limit($attachment->file_name, $maxLength, '');
                                $extension = pathinfo($attachment->file_name, PATHINFO_EXTENSION);
                            
                                // Check if the file name was truncated
                                if (strlen($attachment->file_name) > $maxLength) {
                                    $partialFileName .= ' . . .' . $extension;
                                }
                            @endphp
                        
                                <a href="#" class="flex text-blue-500 rounded-md my-4 flex items-center p-4 bg-blue-100 hover:bg-blue-200" onclick="viewImage('{{ asset($attachment->file_location) }}', '{{ $attachment->file_name }}', {{ $loop->index }})">
                                    <i class="fas fa-image text-3xl mr-3"></i> {{ $partialFileName }}
                                </a>
                            @endforeach
                                
                            </ul>
                        </div>
                    @endif                    
                </div>

                

            </div>
        </div>

        <div class="w-3/4" style="">
            <div class="overflow-y-auto autoScroll" style="height: 69.5vh; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    @include('_replies')
                </div>
            </div>
            <div class="mb-0 p-4 pb-2 bg-white border rounded-md">
                <form action="{{ route('office.tickets.reply', $ticket->id) }}" method="POST" style="m-0 p-0">
                    @csrf
                    <div class="">
                        <textarea name="content" class="border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" id="comment" rows="2" placeholder="Enter your reply" autofocus></textarea>
                    </div>
                    <div class="absolute right-9 flex items-center" style="transform: translateY(-130%)">
                        <a href="#"><ion-icon name="attach-outline" class="text-3xl text-gray-600 p-1 hover:bg-blue-200 rounded-full"></ion-icon></a>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 " type="submit">Submit Reply</button>
                    </div>
                </form>
            </div>
        </div>
        
        

    </div>

    <!-- View Image -->
    <div id="imageTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-90 flex items-center justify-center py-8" style="display: none; backdrop-filter: blur(5px);">
        <div class="absolute text-4xl grid grid-cols-2 gap-6" style="top: 20px; right:20px">
            <a href="#" onclick="downloadImage()" class="text-white font-bold">
                <ion-icon name="download-outline"></ion-icon>
            </a>
            <a href="#" onclick="hideimageTab()" class="text-white font-bold">
                <ion-icon name="close"></ion-icon>
            </a>
        </div>
        @if ($ticket->attachments->count() > 1)
        <div>
            <a href="#" onclick="prevImage()" class="text-6xl text-white font-bold absolute" style="top: 45%; left: 20px">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </a>
            <a href="#" onclick="nextImage()" class="text-6xl text-white font-bold absolute" style="top: 45%; right: 20px">
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </a>
        </div>
        @endif
        <img id="imagePreview" src="" alt="" class="h-full">
    </div>

    <!-- Assign Modal -->
    <div id="assignTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
        <div id="form"  class="bg-white rounded-lg shadow-lg" style="width: 400px; max-width: 90vw;">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Ticket ID {{ $ticket->id }}</h3>
                    <a href="#" onclick="hideAssignTab()" class="text-gray-600 hover:text-gray-800 transition-colors duration-200">
                        <ion-icon name="close-outline" class="text-2xl"></ion-icon>
                    </a>
                </div>
                <p class="mb-4 font-bold">{{ $ticket->subject }}</p>
                <form action="{{ route('tickets.assign', $ticket) }}" method="POST" class="bg-white border shadow-md rounded-lg p-6">
                    @csrf
                    <div class="mb-6">
                        <label for="assigned_to" class="block text-gray-700 font-semibold mb-2">Assign To</label>
                        <select name="assigned_to" id="assignee" class="block w-full px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                            <option value="" class="text-gray-500">Select a user</option>
                            @foreach ($officers as $user)
                                <option value="{{ $user->id }}" class="text-gray-900">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button onclick="hideAssignTabs()" type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <ion-icon name="person-add-outline" class="mr-2"></ion-icon>
                            Assign Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        let currentIndex = 0;
        const attachments = @json($ticket->attachments->pluck('file_location'));
        const fileNames = @json($ticket->attachments->pluck('file_name'));

        function viewImage(imageUrl, fileName, index) {
            const img = document.getElementById('imagePreview');
            img.src = imageUrl;
            img.dataset.fileName = fileName;
            const imageTab = document.getElementById('imageTab');
            imageTab.style.display = "flex";
            currentIndex = index;
        }
        function hideimageTab() {
            const img = document.getElementById('imageTab');
            img.style.display = "none";
        }


        function showAssignTab() {
            const assignTab = document.getElementById('assignTab');
            const form = document.getElementById('form');
            assignTab.style.display = 'flex';
            assignTab.classList.add('animated-show');
            form.classList.add('animated-pulse');

            document.addEventListener('click', function(event) {
                if (!assignTab.contains(event.target) && !event.target.closest('.options')) {
                    hideAssignTab();
                }
            });
        }

        function hideAssignTab() {
            const assignTab = document.getElementById('assignTab');
            const form = document.getElementById('form');
            assignTab.classList.add('animated-vanish');
            form.classList.add('animated-close');

            setTimeout(() => {
                assignTab.style.display = 'none';
                assignTab.classList.remove('animated-pulse');
                form.classList.remove('animated-close');
                assignTab.classList.remove('animated-vanish');
            }, 300);
        }    

        function hideAssignTabs() {
            const assignTab = document.getElementById('assignTab');
            const form = document.getElementById('form');
            assignTab.classList.add('animated-vanish');
            form.classList.add('animated-close');

            setTimeout(() => {
                assignTab.style.display = 'none';
                assignTab.classList.remove('animated-pulse');
                form.classList.remove('animated-close');
                assignTab.classList.remove('animated-vanish');
            }, 300);
        }    

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' || event.keyCode === 27) {
                hideAssignTab();
                hideimageTab();
            }
        });

        function downloadImage() {
            const imageUrl = document.getElementById('imagePreview').src;
            const fileName = document.getElementById('imagePreview').dataset.fileName;
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = fileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function prevImage() {
            currentIndex = (currentIndex === 0) ? attachments.length - 1 : currentIndex - 1;
            const imageUrl = "{{ asset('/') }}" + attachments[currentIndex];
            const fileName = fileNames[currentIndex];
            document.getElementById('imagePreview').src = imageUrl;
            document.getElementById('imagePreview').dataset.fileName = fileName;
        }

        function nextImage() {
            currentIndex = (currentIndex === attachments.length - 1) ? 0 : currentIndex + 1;
            const imageUrl = "{{ asset('/') }}" + attachments[currentIndex];
            const fileName = fileNames[currentIndex];
            document.getElementById('imagePreview').src = imageUrl;
            document.getElementById('imagePreview').dataset.fileName = fileName;
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowLeft') {
                prevImage();
            } else if (event.key === 'ArrowRight') {
                nextImage();
            }
        });

    </script>
</x-app-layout>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        // Fetch and display real-time data
        function fetchReplies() {
            $.get("{{ route('office.tickets.replies', $ticket->id) }}", function(data){
                $(".replies-container").html(data);
                // $(".top-options").html(data);
                scrollToBottom();
            });
        }
        function fetchUpdates() {
            $.get("{{ route('office.tickets.updates', $ticket->id) }}", function(data){
                $(".top-options").html(data);
                // scrollToBottom();
            });
        }
        
        // Call the fetchReplies function initially and then at intervals
        fetchUpdates()
        setInterval(fetchUpdates, 5000);
        fetchReplies();
        setInterval(fetchReplies, 5000); // Fetch every 5 seconds
        
        // Submit reply via Ajax
        $("form").submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.post($(this).attr("action"), formData, function(data){
                // Refresh replies after submission
                fetchReplies();
                $("textarea").val(""); // Clear textarea
                scrollToBottom();
            });
        });

        // Scroll to the bottom of the replies container
        function scrollToBottom() {
            var repliesContainer = $(".autoScroll");
            // setTimeout(function() {
                repliesContainer.scrollTop(repliesContainer[0].scrollHeight);
            // }, 300);
        }
    });
</script>
