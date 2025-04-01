<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBot Data Bank</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="icon" href="{{ asset('images/botbot.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to bottom right, #3b82f6, #ffffff);

        }
        .chat-container {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
            height: 75%;
        }
        .pattern-input {
            flex-grow: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            width: 100%;
            height: 100px;
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
            transition: all 0.3s ease;
            width: 100%;
            height: 500px;
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
        .form-container {
    
        }
        .reveals {
            display: none;
        }
        
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="chat-container h-full w-full">
        <div class="chat-header">
            <img src="{{ asset('images/bot.png') }}" id="botImage" class="mx-auto h-24 w-auto mb-4" alt="Bot Image">
            <h1 class="text-2xl font-bold">NotGPT Data Bank</h1>
            <p class="text-sm mt-2">Powered by Pangasinan State University</p>
        </div>
        <!-- Display success message if data is successfully stored -->
        {{-- @if (session('success'))
            <div>{{ session('success') }}</div>
        @endif --}}
        <!-- Display existing records below the form -->
        <div class="px-32 py-4">

            

            @if ($dataBanks->isEmpty())
                <p class="py-8 flex items-center justify-center">No records found.</p>
            @else

                <table class="my-6" border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr class="bg-blue-200">
                            <th class="w-16">ID</th>
                            <th class="w-1/6">Chat Pattern</th>
                            <th>Chat Response</th>
                            <th class="w-1/6">Author</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataBanks as $dataBank)
                            <tr>
                                <td class="text-center">{{ $dataBank->id }}</td>
                                <td>{{ $dataBank->chatPattern }}</td>
                                <td>{{ $dataBank->chatResponse }}</td>
                                <td>{{ $dataBank->author->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="#" class="flex text-5xl text-blue-500 items-center justify-center" onclick="openAdd()"><ion-icon name="add-circle"></ion-icon></a>

        </div>
    </div>

    <!-- Form to create a new data_bank record -->
    <div id="add-pattern" class="absolute top-0 w-screen h-screen reveals" style="background-color: #0008; backdrop-filter: blur(8px);">
        <div class="flex items-center justify-center h-full w-full">
            <div class="form-container input-area">
                <form action="{{ route('data_bank.store') }}" class="grid gap-4" method="POST">
                    @csrf
                    <textarea type="text" id="chatPattern"  class="pattern-input" name="chatPattern" required autofocus placeholder="Chat Pattern"></textarea>

                    <textarea id="chatResponse" name="chatResponse" class="response-input" required placeholder="Chat Response"></textarea>
    
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
</body>
</html>