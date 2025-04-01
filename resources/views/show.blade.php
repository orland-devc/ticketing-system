@section('title', 'Ticket - ' . $ticket->ticket_code)

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center justify-between">
            <div class="flex items-center">
                <a href="http://127.0.0.1:8000/tickets" class="text-2xl hover:bg-blue-100 flex items-center justify-center h-10 w-10 rounded-full" style="transform:translateX(-30%)">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                </a>
                <div class="flex items-center gap-4">
                    <h2 class="font-semibold text-xl text-gray-800">
                        Ticket - {{ $ticket->ticket_code }}
                        {{-- <ion-icon name="ticket" class=""></ion-icon> --}}
                    </h2>
                    @if ( $ticket->level == 'normal' )
                        <p class="capitalize px-4 py-2 rounded-full bg-green-200 text-green-500 font-semibold text-sm">
                    @elseif ( $ticket->level == 'important' )
                        <p class="capitalize px-4 py-2 rounded-full bg-yellow-200 text-yellow-500 font-semibold text-sm">
                    @else 
                        <p class="uppercase px-4 py-2 rounded-full bg-red-200 text-red-600 font-semibold text-sm">
                    @endif
                        {{ $ticket->level }}
                    </p>
                    {{-- <span class="ml-5 mt-2 text-sm text-gray-400">{{ $ticket->created_at->format('M d, Y g:i A') }}</span> --}}
                </div>
            </div>
            <div class="ml-5">
                @include('_updates')
            </div>
        </div>
        
    </x-slot>
    

    <div class="max-w-screen flex p-3 custom-bg h-[90vh]">
        <div class="bg-white border-2 shadow-lg rounded-lg mr-2 w-1/4 min-w-72">
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
                            <img class="h-10 w-10 rounded-full border object-cover" 
                                src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&color=7F9CF5&background=EBF4FF" 
                                alt="{{ $ticket->user->name }}" 
                                style="border: 1px solid blue">
                        @elseif(isset($ticket->user))
                            <img class="h-10 w-10 rounded-full object-cover" 
                                src="{{ asset($ticket->user->profile_picture) }}" 
                                alt="{{ $ticket->user->name }}">
                        @else
                            <img class="h-10 w-10 rounded-full border object-cover" 
                                src="https://ui-avatars.com/api/?name={{ urlencode($ticket->guest_name) }}&color=7F9CF5&background=EBF4FF" 
                                alt="{{ $ticket->guest_name }}" 
                                style="border: 1px solid blue">
                        @endif

                        <div class="">
                            <p class="text-gray-600">{{ $ticket->user->name ?? $ticket->guest_name }}</p>
                            <p class="text-gray-500 text-xs">{{ $ticket->created_at->format('M d, Y g:i A') }}</p>
                        </div>    
                    </div>                
                    @if ($ticket->assigned_to)
                        {{-- <span class="text-gray-400">Assigned to</span> --}}
                        <div class="flex items-center gap-4">
                            <img src="{{ asset($ticket->ticket->profile_picture) }}" alt="" class="h-10 w-10 rounded-full">
                            <p class="text-gray-600">{{ $ticket->ticket->name }} (assigned)</p>
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
                        
                                <a href="#" class="flex justify-between text-blue-500 rounded-md my-4 items-center p-3 bg-blue-100 border-2 border-blue-300 hover:bg-blue-200" onclick="viewImage('{{ asset($attachment->file_location) }}', '{{ $attachment->file_name }}', {{ $loop->index }})">
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

        @if(session('message'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ Session::get('message') }}', 
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 px-4 py-2 rounded'
                    }
                });
            </script>
        @endif

        <div class="w-3/4" style="">
            <div class="overflow-y-auto autoScroll flex flex-col h-[88vh]">
                <div>
                    @include('_replies')
                </div>

                @include('_replysection')
            </div>
        </div>
    
        {{-- @if(session('message'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: "{{ session('message') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
        @endif --}}


        

    </div>

    <!-- View Image -->
    <div id="imageTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-90 flex items-center justify-center py-8" style="display: none; backdrop-filter: blur(5px);">
        <div id="fileName" class="text-white text-2xl flex-col items-center absolute top-10 mx-auto"></div>
        <div class="absolute text-3xl grid grid-cols-2 gap-6" style="top: 20px; right:20px">
            <a href="#" onclick="downloadImage()" class="flex items-center justify-center font-bold text-gray-300 hover:text-white hover:bg-gray-600 p-3 rounded-full w-14 h-14 transition-all duration-200">
                <i class="fa-solid fa-download text-gray-300 hover:text-white"></i>
            </a>
            <a href="#" onclick="hideimageTab()" class="flex items-center justify-center font-bold text-gray-300 hover:text-white hover:bg-gray-600 p-3 rounded-full w-14 h-14 transition-all duration-200">
                <i class="fa-regular fa-circle-xmark text-gray-300 hover:text-white"></i>
            </a>
        </div>
        @if ($ticket->attachments->count() > 1)
        <div>
            <a href="#" onclick="prevImage()" class="text-6xl text-gray-400 hover:text-white font-bold absolute" style="top: 45%; left: 20px">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
            <a href="#" onclick="nextImage()" class="text-6xl text-gray-400 hover:text-white font-bold absolute" style="top: 45%; right: 20px">
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </div>
        @endif
        <img id="imagePreview" src="" alt="" class="h-[80vh] hidden">
        <div id="otherFile" class="hidden text-white text-2xl flex-col items-center gap-8"></div>

        
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

        function viewImage(imageUrl, fileName, index, fileExtension) {
            const img = document.getElementById('imagePreview');
            const otherFile = document.getElementById('otherFile');
            const titleName = document.getElementById('fileName');
            if (fileName.endsWith('.jpg') || fileName.endsWith('.jpeg') || fileName.endsWith('.png')) {
                otherFile.classList.add('hidden');
                img.classList.remove('hidden');
                titleName.innerHTML = `<p>${fileName}</p>`;
                img.src = imageUrl;
                img.dataset.fileName = fileName;
                const imageTab = document.getElementById('imageTab');
                imageTab.style.display = "flex";
            }
            else {
                titleName.innerHTML = `<p>${fileName}</p>`;
                img.classList.add('hidden');
                otherFile.classList.remove('hidden');
                otherFile.classList.add('flex');
                const imageTab = document.getElementById('imageTab');
                imageTab.style.display = "flex";
                otherFile.innerHTML = `<p>Can't view this file. Please download it.</p><a href="${imageUrl}" class="px-4 py-2 bg-white rounded-xl text-gray-600 hover:text-blue-600" download>Download ${fileName} <i class="fa-solid fa-download ml-4"></i></a>`;
            }
            
            currentIndex = index;
        }
        function hideimageTab() {
            const img = document.getElementById('imageTab');
            img.style.display = "none";
        }

        function scrollToBottom() {
            var repliesContainer = $(".autoScroll");
            repliesContainer.scrollTop(repliesContainer[0].scrollHeight);
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




