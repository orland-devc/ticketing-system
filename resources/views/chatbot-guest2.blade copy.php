<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSU ChatBot</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="icon" href="{{ asset('images/botbot.png') }}" type="image/x-icon">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: Poppins, 'Figtree', sans-serif;
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
            display: flex;
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }
        #user-input {
            flex-grow: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        #user-input:focus {
            box-shadow: 0 2px 15px rgba(103,126,234,0.25);
            outline-color: #3b82f6;
        }
        .send-button {
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-left: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .send-button:hover {
            background-color: #4a66e5;
            transform: scale(1.05);
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
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

    <div class="header select-none shadow bg-white absolute top-0 w-screen">
        <div id="header1" class="mx-auto py-2 px-6 flex items-center justify-between">
            <a href="/login" class="flex items-center">
                <img src="{{ asset('images/PSU logo.png') }}" class="rounded-full h-12 w-12" alt="">
                <h1 class="text-2xl font-bold text-gray-800 ml-4">HelpDeskPro</h1>
            </a>
            <div class="flex items-center side-header select-none">
                <a href="#" onclick="openAddTicket()" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-medium mr-4">
                    Submit a Ticket
                </a>
                <a href="#" onclick="openForm()" class="bg-gray-200 hover:bg-gray-300 text-black px-4 py-2 rounded-md text-sm font-medium">
                    Submit a Ticket
                </a>
                {{-- <a href="#" id="profile_pic" onclick="submitTicket()">
                    <img class="h-8 w-8 rounded-full ml-4 hover:border-blue-500 border-2 transition all duration-300" src="{{ asset(Auth::user()->profile_picture) }}" alt="User avatar">
                </a> --}}
            </div>
        </div>
    </div>

    <div class="chat-container w-full max-w-2xl mt-12">
        <div class="chat-header">
            <img src="{{ asset('images/bot.png') }}" id="botImage" class="mx-auto h-24 w-auto mb-4" alt="Bot Image">
            <h1 class="text-2xl font-bold">{{ $botName->message }} ChatBots</h1>
            <p class="text-sm mt-2">Powered by Pangasinan State University</p>
        </div>
        <div id="chat-messages" class="chat-body">
            <!-- Messages will be inserted here -->
        </div>
        <div class="input-area">
            <input type="text" id="user-input" placeholder="Type your message..." autofocus>
            <button class="send-button">
                <ion-icon name="send"></ion-icon>
            </button>
        </div>
    </div>

    <!-- Ticket Submission Modal -->
    <div id="addGuestTicket" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 overflow-y-auto hidden">
        <form 
            action="{{ route('tickets.guest.store') }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="relative w-full max-w-lg bg-white rounded-xl shadow-2xl p-6 space-y-4"
        >
            @csrf

            {{-- Close Button --}}
            <button 
                type="button" 
                onclick="closeAddTicket()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Form Title --}}
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">
                Submit Ticket as Guest
            </h2>

            {{-- Guest Name --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Your Name
                </label>
                <input 
                    type="text" 
                    name="guest_name" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your full name"
                >
            </div>

            {{-- Birthdate --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Birthdate
                </label>
                <input 
                    type="date" 
                    name="guest_birthdate"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            {{-- Email --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Email (Optional)
                </label>
                <input 
                    type="email" 
                    name="guest_email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your email address"
                >
            </div>

            <div class="flex flex-row gap-4">
                {{-- Ticket Level --}}
                <div class="space-y-2" style="flex: 1">
                    <label class="block text-sm font-medium text-gray-700">
                        Ticket Priority
                    </label>
                    <select 
                        name="level"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="normal">Normal</option>
                        <option value="important">Important</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>

                {{-- Category --}}
                <div class="space-y-2" style="flex: 1">
                    <label class="block text-sm font-medium text-gray-700">
                        Category
                    </label>
                    <input 
                        type="text" 
                        name="category"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter ticket category"
                    >
                </div>
            </div>

            {{-- Subject --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Subject
                </label>
                <input 
                    type="text" 
                    name="subject"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter ticket subject"
                >
            </div>

            {{-- Content --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Ticket Details
                </label>
                <textarea 
                    name="content"
                    required
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Describe your issue in detail"
                ></textarea>
            </div>

            {{-- Attachments --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Attachments
                </label>
                <input 
                    type="file" 
                    name="attachments[]"
                    multiple
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium hover:file:bg-blue-100"
                >
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Submit Ticket
                </button>
            </div>
        </form>
    </div>

    <!-- Ticket Verification Modal -->
    <div id="verifyForm" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 hidden">
        @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ Session::get("success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 px-4 py-2 rounded'
                    }
                });
            </script>
        @endif

        @if(session('message'))
            <script>
                Swal.fire({
                    title: 'Sorry! No Tickets Found',
                    // text: '{{ Session::get('message') }}', 
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 px-4 py-2 rounded'
                    }
                });
            </script>
        @endif
        <form 
            action="{{ route('tickets.guest.verify') }}" 
            method="POST"
            class="relative w-full max-w-md bg-white rounded-xl shadow-2xl p-8 space-y-6"
        >
            @csrf

            {{-- Close Button --}}
            <button 
                type="button" 
                onclick="closeForm()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Form Title --}}
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Verify Your Support Ticket
            </h2>

            {{-- Verification Instructions --}}
            <p class="text-sm text-gray-600 text-center mb-4">
                Please enter the name and birthdate associated with your ticket to verify your identity.
            </p>

            {{-- Guest Name --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Your Name
                </label>
                <input 
                    type="text" 
                    name="guest_name" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your full name"
                >
            </div>

            {{-- Birthdate --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Birthdate
                </label>
                <input 
                    type="date" 
                    name="guest_birthdate"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Verify Ticket
                </button>
            </div>

            {{-- Additional Help --}}
            <div class="text-center text-sm text-gray-600 mt-4">
                <p>
                    Trouble verifying? 
                    <a href="#" class="text-blue-600 hover:underline">
                        Contact Support
                    </a>
                </p>
            </div>
        </form>
    </div>

    <script>
        const addGuestTicket = document.getElementById('addGuestTicket');
        const verifyForm = document.getElementById('verifyForm')
    
        function openAddTicket() {
            addGuestTicket.classList.remove('hidden');
        }

        function closeAddTicket() {
            addGuestTicket.classList.add('hidden');
        }

        function openForm() {
            verifyForm.classList.remove('hidden');
        }

        function closeForm() {
            verifyForm.classList.add('hidden');
        }
        var botProfilePicture = "{{ asset('images/botbot.png') }}";
    </script>
    <script>
        let previousQueries = new Set();
        const conversationContexts = {
    'admission': {
        stages: [
            {
                keywords: [/admission/i, /apply/i, /application/i],
                response: "PSU's admission process is designed to be comprehensive and student-friendly. We offer various programs with streamlined entry procedures. \n\nWhat specific information would you like to know about our admissions?",
                followupTopics: ['requirements', 'process', 'dates']
            },
            {
                keywords: [/requirement/i, /needed/i, /documents/i],
                response: "For admission to PSU, you'll typically need:\n\n **Academic Credentials**\n • Original Copy of Report Card (SHS Graduates)\n • Transfer Credential (Transferees)\n  • Official Transcript of Records (Transferees)\n • Certificate of Good Moral Character\n • Photocopy of PSA Birth Certificate\n • Medical Certificate\n • 2 pcs. 2x2 picture with nametag\n\nEach program may have specific additional requirements. Would you like to know more about specific program requirements?",
                followupTopics: ['documents', 'specific programs', 'process']
            },
            {
                keywords: [/cutoff/i, /deadline/i, /submission/i, /last date/i],
                response: "Admissions for the upcoming academic year began on **March 11, 2025**, and will continue until **September 15, 2025**. \n\n**Note:** Exact dates may vary slightly by program. \n\nWould you like to confirm the deadline for a specific program?",
                followupTopics: ['confirm', 'specific program']
            },
            {
                keywords: [/thanks/i, /thank you/i, /appreciated/i],
                response: "You're welcome! If you need any further assistance with admissions, feel free to ask. Good luck with your application! 🎓",
                followupTopics: []
            }
        ],
        defaultResponse: "I'm here to help you with admission-related queries. Could you please be more specific about what you'd like to know?"
    }
};

let currentConversationContext = null;
let conversationHistory = [];

function processQuery(query) {
    const lowerCaseQuery = query.toLowerCase().trim();

    // If no active context, try to establish one
    if (!currentConversationContext) {
        for (const [contextName, contextData] of Object.entries(conversationContexts)) {
            const initialStage = contextData.stages[0];
            if (initialStage.keywords.some(keyword => keyword.test(lowerCaseQuery))) {
                currentConversationContext = {
                    name: contextName,
                    currentStage: initialStage
                };
                conversationHistory.push(lowerCaseQuery);
                return initialStage.response;
            }
        }
    }

    // If we have an active context
    if (currentConversationContext) {
        const context = conversationContexts[currentConversationContext.name];
        
        // Try to find a matching stage based on keywords
        const matchedStage = context.stages.find(stage => 
            stage.keywords.some(keyword => keyword.test(lowerCaseQuery))
        );

        if (matchedStage) {
            currentConversationContext.currentStage = matchedStage;
            conversationHistory.push(lowerCaseQuery);
            return matchedStage.response;
        }

        // If no specific match, use default response
        return context.defaultResponse;
    }

    // If no context matches
    return "I'm not sure I understand. Could you clarify or rephrase your question?";
}


        

        function createMessageElement(message, isUser) {
            const messageContainer = document.createElement('div');
            messageContainer.className = isUser ? 'message-container user-container' : 'message-container bot-container';

            const messageElement = document.createElement('div');
            messageElement.className = isUser ? 'message user-message' : 'message bot-message';

            if (!isUser) {
                const imageElement = document.createElement('img');
                imageElement.src = botProfilePicture;
                imageElement.className = 'chatImage';
                imageElement.alt = 'Bot';
                messageContainer.appendChild(imageElement);
            }

            messageContainer.appendChild(messageElement);

            return { container: messageContainer, messageElement: messageElement };
        }

        const chatMessages = document.getElementById('chat-messages');
        const userInput = document.getElementById('user-input');
        const sendButton = document.querySelector('.send-button');

        function addMessage(message, isUser) {
            const { container, messageElement } = createMessageElement(message, isUser);
            
            if (isUser) {
                chatMessages.appendChild(container);
                messageElement.textContent = message;
                scrollToBottom();
            } else {
                showTypingIndicator()
                    .then(() => {
                        chatMessages.appendChild(container);
                        messageElement.innerHTML = formatMessage(message);
                        scrollToBottom();
                    });
            }
        }

        function formatMessage(message) {
            // Bold text enclosed in double asterisks
            message = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            
            // Split the message into lines
            let lines = message.split('\n');
            
            let formattedLines = [];
            let inList = false;
            
            for (let line of lines) {
                if (line.startsWith('• ')) {
                    if (!inList) {
                        inList = true;
                        formattedLines.push('<ul>');
                    }
                    formattedLines.push('<li>' + line.substring(2) + '</li>');
                } else {
                    if (inList) {
                        inList = false;
                        formattedLines.push('</ul>');
                    }
                    formattedLines.push(line);
                }
            }
            
            if (inList) {
                formattedLines.push('</ul>');
            }
            
            // Join the lines with <br> tags for newlines
            return formattedLines.join('<br>');
        }

        function showTypingIndicator() {
            const { container, messageElement } = createMessageElement('', false);
            const typingIndicator = document.createElement('div');
            typingIndicator.className = 'typing-indicator';
            typingIndicator.innerHTML = '<span></span><span></span><span></span>';
            messageElement.appendChild(typingIndicator);
            
            chatMessages.appendChild(container);
            scrollToBottom();

            return new Promise((resolve) => {
                setTimeout(() => {
                    chatMessages.removeChild(container);
                    resolve();
                }, 1500); // 1.5 seconds for the typing indicator
            });
        }

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function handleUserInput() {
            const message = userInput.value.trim();
            if (message) {
                addMessage(message, true);
                userInput.value = '';
                const response = processQuery(message);
                setTimeout(() => {
                    addMessage(response, false);
                }, 500);
            }

            // Create a div to hold the buttons with Flexbox
            const buttonContainer = document.createElement("div");
            buttonContainer.classList.add('button-container'); 
            botMessage.appendChild(buttonContainer);

            // Create the Speak button with an icon
            const speakButton = document.createElement("button");
            speakButton.classList.add('primary-button');
            speakButton.id = "volume1";
            speakButton.innerHTML = "<i id='vol1' class='fas fa-volume-up'></i> <i id='spin1' class='fa fa-spinner hidden spinning'></i> ";
            speakButton.onclick = speakBOT;
            buttonContainer.appendChild(speakButton);
        }

        sendButton.addEventListener('click', handleUserInput);
        userInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                handleUserInput();
            }
        });



        
    </script>
    <script>
        // Add an initial bot message
        addMessage('Hi there!', false);
    </script>
</body>
</html>