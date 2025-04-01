<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PSU ChatBot</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="icon" href="{{ asset('images/botbot.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    

<div class="">
    <div class="chat-container h-full w-full">
        <div class="chat-header">
            <img src="{{ asset('images/bot.png') }}" id="botImage" class="mx-auto h-24 w-auto mb-4" alt="Bot Image">
            <h1 class="text-2xl font-bold">{{ $botName->message }} Data Bank</h1>
            <p class="text-sm mt-2">Powered by Pangasinan State University</p>
        </div>
        <!-- Display success message if data is successfully stored -->
        <!-- @if (session('success'))
            <div>{{ session('success') }}</div>
        @endif -->
        <!-- Display existing records below the form -->
        <div class="px-32 py-4">
            <div class="flex items-center justify-center">
                <a href="#" class="text-5xl text-blue-500" onclick="openAdd()"><ion-icon name="add-circle"></ion-icon></a>    
            </div>
                
            <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-12 hidden">
                {{-- Chatbot Name Update Form --}}
                <form action="{{ route('dashboard.nameupdate') }}" method="POST" class="flex-1">
                    @csrf
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Chatbot Name</label>
                    <div class="flex gap-2">
                        <input type="text" id="name" name="name" value="{{ $botName->message ?? '' }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" placeholder="Name your chatbot">
                        <x-primary-button type="submit">Update</x-primary-button>
                    </div>
                </form>
            
                {{-- Chatbot Greeting Update Form --}}
                <form action="{{ route('dashboard.greetupdate') }}" method="POST" class="flex-1">
                    @csrf
                    <label for="greeting" class="block mb-2 text-sm font-medium text-gray-900">Chatbot Greeting Message</label>
                    <div class="flex gap-2">
                        <input type="text" id="greeting" name="greeting" value="{{ $botGreeting->message ?? '' }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" placeholder="Greeting Message">
                        <x-primary-button type="submit">Update</x-primary-button>
                    </div>
                </form>
            
                {{-- Chatbot Fallback Update Form --}}
                <form action="{{ route('dashboard.fallbackupdate') }}" method="POST" class="flex-1">
                    @csrf
                    <label for="fallback" class="block mb-2 text-sm font-medium text-gray-900">Chatbot Fallback Message</label>
                    <div class="flex gap-2">
                        <input type="text" id="fallback" name="fallback" value="{{ $botFallback->message ?? '' }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" placeholder="Fallback Message">
                        <x-primary-button type="submit">Update</x-primary-button>
                    </div>
                </form>

                {{-- Chatbot Repeated Update Form --}}
                <form action="{{ route('dashboard.repeatupdate') }}" method="POST" class="flex-1">
                    @csrf
                    <label for="fallback" class="block mb-2 text-sm font-medium text-gray-900">Chatbot Response on Repeat</label>
                    <div class="flex gap-2">
                        <input type="text" id="repeat" name="repeat" value="{{ $botRepeated->message ?? '' }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" placeholder="Fallback Message">
                        <x-primary-button type="submit">Update</x-primary-button>
                    </div>
                </form>
            </div>
            
            

            @if ($dataBanks->isEmpty())
                <p class="py-8 flex items-center justify-center">No records found.</p>
            @else

            <table class="my-6 w-full overflow-y-hidden" border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="w-1/6">Chat Pattern</th>
                        <th>Chat Response</th>
                        <th class="w-1/6">Author</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataBanks as $dataBank)
                        <tr class="clickable-row cursor-pointer hover:bg-gray-200 transition-all" data-id="{{ $dataBank->id }}">
                            <td>{{ $dataBank->chatPattern }}</td>
                            <td>{{ $dataBank->chatResponse }}</td>
                            <td>
                                @if ($dataBank->created_at != $dataBank->updated_at)
                                    {{ $dataBank->author->name }} <span class="text-sm text-gray-400">(edited)</span>
                                @else
                                    {{ $dataBank->author->name }}                                        
                                @endif
                            </td>
                        </tr>
            
                        {{-- Hidden form for editing the row data --}}
                        <tr class="hidden bg-gray-200" id="form-row-{{ $dataBank->id }}">
                            <td colspan="3" class="">
                                <form action="{{ route('dashboard.update', $dataBank->id) }}" method="POST">
                                    @csrf                
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <label for="chatPattern" class="block mb-2 text-sm font-medium">Chat Pattern</label>
                                            <input type="text" name="chatPattern" value="{{ $dataBank->chatPattern }}" class="w-full bg-gray-50 border border-gray-300 text-md rounded-lg p-2">
                                        </div>
                                        <div>
                                            <label for="chatResponse" class="block mb-2 text-sm font-medium">Chat Response</label>
                                            <textarea name="chatResponse" rows="10" class="w-full bg-gray-50 border border-gray-300 text-md rounded-lg p-2">{{ $dataBank->chatResponse }}</textarea>
                                        </div>
                                        <div class="flex gap-4">
                                            <x-primary-button type="submit" class="">Save Changes</x-primary-button>
                                            <x-cancel-button type="button" class="bg-gray-200 cancel-edit" data-id="{{ $dataBank->id }}">Cancel</x-cancel-button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <style>
                .fall_down {
                    animation: fall_down 0.2s ease-out forwards;
                }
            
                .fall_up {
                    animation: fall_up 0.2s ease-out forwards;
                }
            
                @keyframes fall_down {
                    0% {
                        opacity: 0;
                        display: none;
                    }
                    1% {
                        opacity: 0;
                        display: table-row;
                    }
                    100% {
                        opacity: 1;
                        display: table-row;
                    }
                }
            
                @keyframes fall_up {
                    0% {
                        opacity: 1;
                        display: table-row;
                    }
                    99% {
                        opacity: 0;
                        display: table-row;
                    }
                    100% {
                        opacity: 0;
                        display: none;
                    }
                }
            
                .selected-row {
                    background-color: #e5e7eb; /* Tailwind's bg-gray-200 */
                }
            </style>
            
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let selectedRow = null;
                    let openFormRow = null;
            
                    // Make rows clickable
                    document.querySelectorAll('.clickable-row').forEach(function (row) {
                        row.addEventListener('click', function () {
                            const id = this.getAttribute('data-id');
                            const formRow = document.getElementById('form-row-' + id);
            
                            // Remove highlight from previously selected row
                            if (selectedRow && selectedRow !== this) {
                                selectedRow.classList.remove('selected-row');
                            }
            
                            // Toggle highlight on the clicked row
                            this.classList.toggle('selected-row');
            
                            if (getComputedStyle(formRow).display === 'none') {
                                formRow.style.display = 'table-row';
                                formRow.classList.add('fall_down');
                                formRow.classList.remove('fall_up');
                                selectedRow = this;
                                openFormRow = formRow;
            
                                // Auto-scroll to show the full form
                                setTimeout(() => {
                                    ensureFormVisible(formRow);
                                }, 50); // Small delay to allow for DOM update
                            } else {
                                closeForm(formRow, this);
                            }
                        });
                    });
            
                    // Handle cancel button for forms
                    document.querySelectorAll('.cancel-edit').forEach(function (button) {
                        button.addEventListener('click', function () {
                            const id = this.getAttribute('data-id');
                            const formRow = document.getElementById('form-row-' + id);
                            const dataRow = formRow.previousElementSibling;
            
                            closeForm(formRow, dataRow);
                        });
                    });
            
                    // Add event listener for 'Esc' key
                    document.addEventListener('keydown', function(event) {
                        if (event.key === 'Escape' && openFormRow) {
                            const dataRow = openFormRow.previousElementSibling;
                            closeForm(openFormRow, dataRow);
                        }
                    });
            
                    // Function to close the form and reset styles
                    function closeForm(formRow, dataRow) {
                        formRow.classList.remove('fall_down');
                        formRow.classList.add('fall_up');
                        formRow.addEventListener('animationend', function() {
                            if (formRow.classList.contains('fall_up')) {
                                formRow.style.display = 'none';
                            }
                        }, {once: true});
                        dataRow.classList.remove('selected-row');
                        selectedRow = null;
                        openFormRow = null;
                    }
            
                    // Function to ensure the form is fully visible
                    function ensureFormVisible(formRow) {
                        const rect = formRow.getBoundingClientRect();
                        const windowHeight = window.innerHeight;
                        
                        if (rect.bottom > windowHeight) {
                            const scrollNeeded = rect.bottom - windowHeight + 20; // 20px extra for padding
                            window.scrollBy({
                                top: scrollNeeded,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            </script>
            
            @endif


        </div>
    </div>

    <!-- Form to create a new data_bank record -->
    <div id="add-pattern" class="absolute w-screen h-screen reveals top-0" style="background-color: #0008; backdrop-filter: blur(8px)">
        <div class="flex items-center justify-center h-full w-full">
            <div class="form-container input-area">
                <form action="{{ route('data_bank.store') }}" class="grid gap-4" method="POST">
                    @csrf
                    <input type="text" id="chatPattern"  class="pattern-input" name="chatPattern" required placeholder="Chat Pattern">

                    <textarea id="chatResponse" rows="10" name="chatResponse" class="response-input" required placeholder="Chat Response"></textarea>
    
                    <div class="flex">
                        <button class="send-button flex-1" type="submit">Submit</button>
                        <a id="close-add" class="cancel-button flex-1" onclick="closeAdd()">Cancel</a>    
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    

    <script>
        var botProfilePicture = "{{ asset('images/botbot.png') }}";
    </script>
    <script src="{{ asset('js main/queryProcessor.js') }}"></script>

    <script>
        function openAdd() {
            const addPattern = document.getElementById('add-pattern');
            addPattern.classList.remove('reveals');

        }
        
        function closeAdd() {
            const addPattern = document.getElementById('add-pattern');
            // Check if the class 'reveals' is not already present
            if (!addPattern.classList.contains('reveals')) {
                addPattern.classList.add('reveals');
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAdd();
            }
        });

    </script>
</div>

<style>
    body {
        font-family: 'Figtree', sans-serif;

    }
    .chat-container {
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .chat-header {
        background: linear-gradient(90deg, #dae9fe 0%, #bfdcfe 100%);
        padding: 20px;
        color: #5c74b0;
        text-align: center;
    }
    .chat-body {
        height: 500px;
        overflow-y: auto;
        padding: 20px;
    }
    .message-container {
        display: flex;
        margin-bottom: 20px;
    }
    .user-container {
        justify-content: flex-end;
    }
    .bot-container {
        justify-content: flex-start;
    }
    .message {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 18px;
        position: relative;
        animation: fadeIn 0.3s ease-out;
    }
    .user-message {
        background-color: #667eea;
        color: white;
        border-bottom-right-radius: 4px;
    }
    .bot-message {
        background-color: #f0f0f0;
        color: #333;
        border-bottom-left-radius: 4px;
        margin-left: 10px;
    }
    .bot-message:hover {
        background-color: #e2e2e2;
    }
    .chatImage {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .input-area {
        padding: 20px;
        border-top: 1px solid #e9ecef;
        background-color: rgba(255, 255, 255, 0.9); /* Slightly white background */
        border-radius: 10px; /* Rounded corners */
        padding: 20px; /* Padding around the form */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        width: 500px; /* Change this to your desired width */
        max-width: 90%; /* Optional: Make it responsive */
        max-height: 80%;
    }
    .pattern-input {
        flex-grow: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 30px;
        font-size: 16px;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        transition: box-shadow 0.3s ease;
        width: 100%;
    }
    .pattern-input:focus {
        box-shadow: 0 2px 15px rgba(103,126,234,0.25);
        outline-color: #3b82f6;
    }
    .response-input {
        flex-grow: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 30px;
        font-size: 16px;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        transition: box-shadow 0.3s ease;
        width: 100%;
    }
    .response-input:focus {
        box-shadow: 0 2px 15px rgba(103,126,234,0.25);
        outline-color: #3b82f6;
    }
    .send-button {
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 15px;
        margin-left: 10px;
        padding: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .send-button:hover {
        background-color: #1e6ff2;
        transform: scale(1.01);
    }
    .cancel-button {
        background-color: #fd5353;
        color: #fff;
        border: none;
        border-radius: 15px;
        margin-left: 10px;
        padding: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cancel-button:hover {
        background-color: #e23535;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .chat-body::-webkit-scrollbar {
        width: 6px;
    }
    .chat-body::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .chat-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    .chat-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    .typing-indicator {
        display: inline-block;
        width: 40px;
    }
    .typing-indicator span {
        height: 8px;
        width: 8px;
        float: left;
        margin: 0 1px;
        background-color: #9E9EA1;
        display: block;
        border-radius: 50%;
        opacity: 0.4;
    }
    .typing-indicator span:nth-of-type(1) {
        animation: 1s blink infinite 0.3333s;
    }
    .typing-indicator span:nth-of-type(2) {
        animation: 1s blink infinite 0.6666s;
    }
    .typing-indicator span:nth-of-type(3) {
        animation: 1s blink infinite 0.9999s;
    }
    @keyframes blink {
        50% {
            opacity: 1;
        }
    }
    table {
        border-collapse: collapse;
        border: 2px solid #aaa;
        margin: auto;
        width: 90%;
    }
    th {
        border: 2px solid #aaa;
    }
    td {
        border: 2px solid #aaa;
    }
    caption {
        border: 2px solid #aaa;
        border-bottom: 0;
    }
    /* .form-container {

    } */
    .reveals {
        display: none;
        }
        
</style>
</body>
</html>