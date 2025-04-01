@section('title', 'Ticket ID ' . $ticket->id)


<x-office-layout>
    <x-slot name="header">
        <div class="w-full flex items-center justify-between">
            <div class="flex items-center">
                <a href="http://127.0.0.1:8000/my-tickets" class="text-2xl hover:bg-blue-100 flex items-center justify-center h-8 w-8 rounded-full" style="transform:translateX(-30%)">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                </a>
                <div class="flex items-center gap-4">
                    <h2 class="font-semibold text-xl text-gray-800">
                        Ticket ID {{ $ticket->id }}
                        {{-- <ion-icon name="ticket" class=""></ion-icon> --}}
                    </h2>
                    @if ( $ticket->level == 'normal' )
                        <p class="capitalize px-4 py-2 rounded-full bg-green-200 text-green-500 font-semibold text-sm">
                    @elseif ( $ticket->level == 'important' )
                        <p class="capitalize px-4 py-2 rounded-full bg-yellow-200 text-yellow-600 font-semibold text-sm">
                    @else 
                        <p class="uppercase px-4 py-2 rounded-full bg-red-200 text-red-600 font-semibold text-sm">
                    @endif
                        {{ $ticket->level }}
                    </p>
                    {{-- <span class="ml-5 mt-2 text-sm text-gray-400">{{ $ticket->created_at->format('M d, Y g:i A') }}</span> --}}
                </div>
            </div>

            @if ($ticket->assigned_to === Auth::user()->id)
                <div class="flex items-center space-x-3">
                    @if ($ticket->status == 'closed')
                        <p class="italic text-sm">This ticket has been closed at {{ $ticket->updated_at->format('M d, Y h:i A') }}</p>
                    @else
                        <a href="#" class="options px-4 py-2 hover:bg-blue-200" title="Assign" onclick="showReplySection()">
                            <i class="fas fa-reply mr-2"></i>
                            Reply
                        </a>        
                        <a href="#" class="options px-4 py-2 hover:bg-blue-200">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send as message
                        </a>          
                        @if ($ticket->assigned_to == Auth::user()->id)
                            <form action="{{ route('tickets.returnToQueue', $ticket->id) }}" method="POST" onsubmit="handleReturnTicket(event, this)">
                                @csrf
                                <button class="bg-blue-400 text-white px-4 py-2 rounded-md font-bold">
                                    Return Ticket to Admin
                                </button>
                            </form>

                            <script>
                                function handleReturnTicket(event, form) {
                                    event.preventDefault();
                                    
                                    if (!confirm('Are you sure you want to return this ticket to the queue?')) {
                                        return;
                                    }

                                    fetch(form.action, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                        },
                                        body: new URLSearchParams(new FormData(form))
                                    })
                                    .then(response => {
                                        if (response.ok) {
                                            window.location.reload();
                                        }
                                    })
                                    .catch(error => console.error('Error:', error));
                                }
                            </script>
                        @endif
                        
                    @endif
                    
                </div>
            @endif
            
        </div>
    </x-slot>

    <div class="max-w-screen flex p-3 bg-gray-100">
        <div class="bg-white border border-2 shadow-lg rounded-lg mr-2 w-1/4 min-w-72 border">
            <div class="flex items-center text-2xl m-auto py-4 px-6">
                <h2 class="text-xl font-semibold text-gray-800 text-center">
                    {{ $ticket->category }}
                    <ion-icon name="ticket" class="mr-2 text-gray-400" style="margin-top: -5px;"></ion-icon>
                </h2>
            </div>
            <hr class="border">
            <div class="py-4 px-6 overflow-y-auto ticket-content h-[78vh]">
                <div class="mb-4">
                    <div class="flex items-center gap-4 mb-6">
                        @if(isset($ticket->user) && empty($ticket->user->profile_picture))
                            <img class="h-10 w-10 rounded-full border" src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $ticket->user->name }}" style="border: 1px solid blue">
                        @elseif(isset($ticket->user))
                            <img class="h-10 w-10 rounded-full" src="{{ asset($ticket->user->profile_picture) }}" alt="{{ $ticket->user->name }}">
                        @else
                            <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($ticket->guest_name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $ticket->guest_name }}" style="border: 1px solid blue">
                        @endif
                        <div class="">
                            <p class="text-gray-400">{{ $ticket->user->name ?? $ticket->guest_name }}</p>
                            <p class="text-gray-400 text-xs">{{ $ticket->created_at->format('M d, Y g:i A') }}</p>
                        </div>    
                    </div>                
                    @if ($ticket->assigned_to)
                        {{-- <span class="text-gray-400">Assigned to</span> --}}
                        <div class="flex items-center gap-4">
                            <img src="{{ asset($ticket->ticket->profile_picture) }}" alt="" class="h-10 w-10 rounded-full">
                            <p class="text-gray-400">{{ $ticket->ticket->name }} (assigned)</p>
                        </div>
                    @endif
                </div>
                
                <hr style="border: 1px dashed #ccc;">

                <div class="mb-6">
                    <div class="flex items-center my-3">
                        {{-- <ion-icon name="document-text-outline" class="text-3xl text-blue-500 mr-4"></ion-icon> --}}
                        <h4 class="text-lg font-semibold text-gray-800">{{ $ticket->subject }}</h4>
                    </div>
                    @php
                        $plainContent = $ticket->content; // Get the raw content
                        $singleLineContent = preg_replace('/\r\n|\r|\n/', ' ', $plainContent); // Remove newlines and replace with a space
                        $contentLength = Str::length($plainContent); // Get the plain content length
                        $partialContent = Str::limit($singleLineContent, 70, ' . . .'); // Limit the single-line content to 70 characters
                    @endphp
                    
                    <div class="mb-4">
                        <!-- Display the partial content with nl2br applied -->
                        <p class="text-gray-600" id="partialContent">{{$partialContent}}</p>
                        
                        <!-- Display the full content, hidden by default -->
                        <p class="text-gray-600 hidden" id="fullContent">{!! nl2br(e($plainContent)) !!}</p>
                        
                        @if ($contentLength > 70 || strpos($plainContent, "\n") !== false)
                            <a href="#" id="readMore" class="text-blue-500 flex items-center mt-0 font-semibold">
                                Read more &nbsp;
                                <ion-icon name="arrow-forward"></ion-icon>
                            </a>
                        @endif
                    
                        <a href="#" id="readLess" class="text-blue-500 flex items-center mt-0 font-semibold hidden">
                            Read less &nbsp;
                            <ion-icon name="arrow-back"></ion-icon>
                        </a>
                    </div>
                

                    <style>
                        .options {
                            font-size: 18px;
                            display: flex;
                            align-items: center;
                            background: #f0f9ff;
                            border-radius: 6px;
                            color: #0076b0;
                            font-size: 16px;
                            transition: background-color 0.3s ease;
                        }
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
                        .side-header {
                            display: none;
                        }
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
                        
                                <a href="#" class="flex justify-between text-blue-500 rounded-md my-4 flex items-center p-3 bg-blue-100 border-2 border-blue-300 hover:bg-blue-200" onclick="viewImage('{{ asset($attachment->file_location) }}', '{{ $attachment->file_name }}', {{ $loop->index }})">
                                    <div class="flex items-center  gap-4">
                                        @if (Str::contains($attachment->file_name, '.pdf'))
                                            <img src='{{ asset("images/PDF_icon2.png") }}' alt="" class="h-12 w-12 rounded-md object-cover object-center">
                                        @else
                                            <img src="{{ asset($attachment->file_location) }}" alt="" class="h-12 w-12 rounded-md object-cover object-center">
                                        @endif
                                        {{ $partialFileName }}
                                    </div>
                                        
                                    <div>
                                        @if ($attachment->getSize() > 999999)
                                            <span class="text-xs text-gray-500">{{ number_format($attachment->getSize() / (1024 * 1024), 2) }} MB</span>
                                        @else
                                            <span class="text-xs text-gray-500">{{ number_format($attachment->getSize() / 1024, 0) }} KB</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                                
                            </ul>
                        </div>
                    @endif                    
                </div>

                

            </div>
        </div>

        <div class="w-3/4" style="">
            <div class="overflow-y-auto autoScroll flex flex-col h-[88vh]">
                <div>
                    @include('_replies')
                </div>

                @include('_replysection')

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
</x-office-layout>




