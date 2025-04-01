@section('title', 'Ticket Details')

<x-users-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="http://127.0.0.1:8000/my-tickets" class="ml-0 pl-0">
                <ion-icon name="arrow-back-outline" class="text-gray-600 hover:text-blue-500 transition-colors duration-200"></ion-icon>
            </a>
            {{ __('Ticket Details') }} {{$ticket->id}}
        </h2>
    </x-slot>

    <div class="max-w-screen bg-white">
        <div class="bg-white rounded-lg" style="height: ">
            <div class="p-6 overflow-y-auto autoScroll" style="max-height: 80vh">
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $ticket->subject }}</h3>
                    <p class="text-gray-600">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                </div>

                @if ($ticket->attachments->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @else
                    <div>
                @endif
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
                        <div class="flex items-center mb-4">
                            <ion-icon name="person-circle-outline" class="text-3xl text-blue-500 mr-4"></ion-icon>
                            <h4 class="text-lg font-semibold text-gray-800">User Information</h4>
                        </div>
                        <p class="text-gray-600 mb-2"><strong>Name:</strong> {{ $ticket->user->name }}</p>
                        <p class="text-gray-600 mb-2"><strong>Category:</strong> {{ $ticket->category }}</p>
                        @if (empty($ticket->ticket->name))
                        @else
                        <p class="text-gray-600 mb-2"><strong>Assigned To:</strong> {{ $ticket->ticket ? $ticket->ticket->name : '-' }}</p>
                        @endif
                        @if ($ticket->status == 'closed')
                            <p class="text-gray-600 mb-2"><strong>Closed at:</strong> {{ $ticket->updated_at->format('M d, Y h:i A') }}</p>
                        @endif
                    </div>
                    @if ($ticket->attachments->isNotEmpty())
                        <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
                            <div class="flex items-center mb-4">
                                <ion-icon name="attach-outline" class="text-3xl text-blue-500 mr-4"></ion-icon>
                                <h4 class="text-lg font-semibold text-gray-800">Attachments</h4>
                            </div>
                            <ul class="list-disc list-inside">
                                @foreach ($ticket->attachments as $attachment)
                                <li class="" style="list-style: none">
                                    <a href="#" class="flex text-blue-500" onclick="viewImage('{{ asset($attachment->file_location) }}', '{{ $attachment->file_name }}', {{ $loop->index }})">
                                        <img src="{{ asset($attachment->file_location) }}" alt="" width="20"> &nbsp; {{ $attachment->file_name}}
                                    </a>
                                </li>
                                @endforeach
                                
                            </ul>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
                        <div class="flex items-center mb-4">
                            <ion-icon name="document-text-outline" class="text-3xl text-blue-500 mr-4"></ion-icon>
                            <h4 class="text-lg font-semibold text-gray-800">Description</h4>
                        </div>
                        <p class="text-gray-600">{{ $ticket->content }}</p>
                    </div>
                </div>

                <div>
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <ion-icon name="chatbubble-ellipses-outline" class="text-3xl text-blue-500 mr-4"></ion-icon>
                            <h4 class="text-lg font-semibold text-gray-800">Reply Thread</h4>
                        </div>
                        @include('_replies')

                        <div class="absolute bottom-2 left-72 right-0 px-10 bg-white ">
                            <form action="{{ route('office.tickets.reply', $ticket->id) }}" method="POST" class="mt-5">
                                @csrf
                                <div class="mb-4">
                                    {{-- <label class="block text-gray-700 font-semibold mb-2" for="comment">Leave a reply</label> --}}
                                    <textarea name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" id="comment" rows="2" placeholder="Enter your reply"></textarea>
                                </div>
                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500" type="submit">Submit Reply</button>
                            </form>
                        </div>
                        
                    </div>
                </div>
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
</x-users-layout>


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

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' || event.keyCode === 27) {
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        // Fetch and display real-time data
        function fetchReplies() {
            $.get("{{ route('office.tickets.replies', $ticket->id) }}", function(data){
                $(".replies-container").html(data);
                scrollToBottom();
            });
        }
        
        // Call the fetchReplies function initially and then at intervals
        fetchReplies();
        setInterval(fetchReplies, 500); // Fetch every 5 seconds
        
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
            setTimeout(function() {
                repliesContainer.scrollTop(repliesContainer[0].scrollHeight);
            }, 300);        }
    });
</script>
