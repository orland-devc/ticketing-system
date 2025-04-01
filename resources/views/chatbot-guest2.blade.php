<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSU ChatBot</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons/dist/ionicons/ionicons.js"></script>
    <link rel="icon" href="{{ asset('images/PSU logo.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Highlight.js for syntax highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Your existing CSS styles */
        body {
            font-family: 'Poppins', sans-serif;
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
            transition: all 0.3s ease;
        }
        #user-input:focus {
            outline: none;
            box-shadow: 0 2px 15px rgba(103,126,234,0.25);
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
            background-color: #764ba2;
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
        .button-container {
            display: flex;
            margin-top: 5px;
            justify-content: flex-end;
        }
        .primary-button {
            background-color: #e0e0e0;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            margin-left: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .primary-button:hover {
            background-color: #d0d0d0;
        }
        .hidden {
            display: none;
        }
        .spinning {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }



        /* Code Block Container */
        .code-block {
            background-color: #2d3748;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            border: 1px solid #4a5568;
            margin: 0; /* Remove all margins */
            margin-top: 20px; 
        }

        /* Header Area */
        .code-block-header {
            background-color: #1a202c;
            padding: 10px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #cbd5e0;
            font-size: 14px;
            border-bottom: 1px solid #4a5568;
            margin: 0; /* Ensure no margins */
        }

        /* Language Label */
        .language-label {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-left: 5px;
            display: flex;
            align-items: center;
            height: 100%;
        }

        /* Copy Button */
        .copy-button {
            background-color: #4a5568;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .copy-button:hover {
            background-color: #5a67d8;
        }

        /* Code Styling */
        .code-block pre {
            padding: 16px;
            margin: 0;
            font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.6;
            overflow-x: auto;
            white-space: pre; /* Crucial: preserve whitespace and line breaks */
        }

        /* Remove any potential padding from the code element */
        .code-block pre code {
            padding: 0;
            white-space: pre; /* Enforce line breaks in code */
            word-break: normal;
            word-wrap: normal;
            display: block;
        }

        .code-block pre, 
        .code-block code {
            tab-size: 4;
            -moz-tab-size: 4;
        }

        .hljs {
            background-color: transparent !important;
            color: #e2e8f0 !important;
        }

        /* Syntax highlighting colors */
        .hljs-keyword {
            color: #93c5fd !important; /* Light blue */
        }

        .hljs-built_in, .hljs-method {
            color: #60a5fa !important; /* Lighter blue for log method */
        }

        .hljs-string {
            color: #fca5a5 !important; /* Light red */
        }

        .hljs-number, .hljs-literal {
            color: #86efac !important; /* Light green */
        }

        .hljs-function, .hljs-title {
            color: #c4b5fd !important; /* Light purple */
        }

        .hljs-comment {
            color: #64748b !important; /* Muted gray */
            font-style: italic;
        }

        .hljs-operator {
            color: #f9a8d4 !important; /* Light pink */
        }

        /* Ensure the message formatting doesn't add extra spacing */
        .message br + .code-block {
            margin-top: 0;
        }

    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="chat-container w-full max-w-2xl">
        <div class="chat-header">
            <img src="{{ asset('images/bot.png') }}" id="botImage" class="mx-auto h-24 w-auto mb-4" alt="Bot Image">
            <h1 class="text-2xl font-bold">NotGPT ChatBot</h1>
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

    <script>
        const API_KEY = "28e13283f94d929a31efd238777e9ab31397c10daf39f20fad930bace8bd5a9a";
        const MODEL = "meta-llama/Llama-3.3-70B-Instruct-Turbo-Free";
        const AXIOS_POST = "https://api.together.xyz/v1/chat/completions";
        const botProfilePicture = "{{ asset('images/botbot.png') }}";
    
        let chatContext = [
            {
                "role": "univeristy guide", 
                "content": "You are an AI assistant for Pangasinan State University (PSU). Respond to questions about university-related queries and topics. Keep responses helpful, concise, and friendly. PROVIDE ONLY FACTUAL INFORMATION AND DON'T MAKE UP YOUR OWN, IT CAN CAUSE SERIOUS TROUBLE AND CONFUSION. Don't say such unverified information. Your role is very sensitive. If you don't know the answer to a specific question or concern, tell them to `create a ticket` for their concern, and don't ever say to check university's website because you are part of the website. Remember: keep responses brief and direct. Focus solely on University-based concerns; do not do student activities, assignments, essays, and coding."
            }
        ];
    
        async function getAIResponse(message) {
            try {
                chatContext.push({ "role": "user", "content": message });
    
                if (chatContext.length > 11) {
                    chatContext = [chatContext[0], ...chatContext.slice(-10)];
                }
    
                const response = await axios.post(
                    AXIOS_POST,
                    { model: MODEL, messages: chatContext, max_tokens: 1000, temperature: 0.7 },
                    { headers: { "Content-Type": "application/json", "Authorization": `Bearer ${API_KEY}` } }
                );
    
                const aiResponse = response.data.choices[0].message.content;
                chatContext.push({ "role": "assistant", "content": aiResponse }); 
                return aiResponse;

                console.log('Response provided!' . aiResponse)
            } catch (error) {
                console.error("Error calling AI API:", error.response ? error.response.data : error.message);
                return "I'm having trouble connecting to my brain right now. Please try again later or contact support.🤖";
            }
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
                showTypingIndicator().then(() => {
                    chatMessages.appendChild(container);
                    messageElement.innerHTML = formatMessage(message);
                    scrollToBottom();
    
                    // Add speak button if it's a bot message
                    const buttonContainer = document.createElement("div");
                    buttonContainer.classList.add('button-container');
                    messageElement.appendChild(buttonContainer);
    
                    const speakButton = document.createElement("button");
                    speakButton.classList.add('primary-button');
                    speakButton.innerHTML = "<i class='fas fa-volume-up'></i>";
                    speakButton.onclick = () => speakText(message, speakButton);
                    buttonContainer.appendChild(speakButton);
    
                    // Highlight code blocks
                    document.querySelectorAll('pre code').forEach((block) => {
                        hljs.highlightBlock(block);
                    });
                });
            }
        }
    
        function formatMessage(message) {
            // Detect code blocks (enclosed in triple backticks)
            const codeBlockRegex = /```(\w+)?\s*\n([\s\S]*?)```/g;

            message = message.replace(codeBlockRegex, (match, language, code) => {
                // Default to 'plaintext' if no language is specified
                const lang = language || 'plaintext';
                
                // Escape HTML but maintain whitespace structure
                const formattedCode = code.trim()
                    .replace(/&/g, '&amp;');
                
                // Create a clean code block - no need to replace \n with <br> for code
                return `<div class="code-block"><div class="code-block-header"><span class="language-label">${lang}</span><button class="copy-button" onclick="copyCode(this)">Copy</button></div><pre><code class="language-${lang}">${formattedCode}</code></pre></div>`;
            });

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

            if (inList) formattedLines.push('</ul>');
            
            // Join lines with <br> but avoid adding <br> right before code blocks
            let result = '';
            for (let i = 0; i < formattedLines.length; i++) {
                result += formattedLines[i];
                if (i < formattedLines.length - 1 && !formattedLines[i].includes("</div>") && !formattedLines[i+1].includes("<div class=\"code-block\">")) {
                    result += '<br>';
                }
            }
            
            return result;
        }

        // Update the copy function to properly maintain line breaks
        function copyCode(button) {
            // Find the code element based on the header button
            const codeBlock = button.closest('.code-block');
            const codeElement = codeBlock.querySelector('pre code');
            
            // Get the text content with preserved formatting
            const code = codeElement.textContent || codeElement.innerText;
            
            // Create a temporary textarea element to copy from
            const textarea = document.createElement('textarea');
            textarea.value = code;
            textarea.setAttribute('readonly', '');
            textarea.style.position = 'absolute';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            
            // Select and copy
            textarea.select();
            document.execCommand('copy');
            
            // Remove the textarea
            document.body.removeChild(textarea);
            
            // Show copied confirmation
            button.textContent = "Copied!";
            setTimeout(() => {
                button.textContent = "Copy";
            }, 2000);
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
    
        async function speakText(text, speakButton) {
            const plainText = text.replace(/<[^>]*>/g, ''); // Strip HTML tags
    
            // Change icon to loading
            speakButton.innerHTML = "<i class='fas fa-spinner fa-spin'></i>";
    
            const apiKey = "sk_fbb20533bf5d2cf8bbec51f86e146c70f7d270ba4c30a07b";
            const voiceId = "WTUK291rZZ9CLPCiFTfh";
    
            try {
                const response = await fetch(
                    `https://api.elevenlabs.io/v1/text-to-speech/${voiceId}`,
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "xi-api-key": apiKey
                        },
                        body: JSON.stringify({
                            text: plainText,
                            voice_settings: { stability: 0.5, similarity_boost: 0.75 }
                        })
                    }
                );
    
                if (response.ok) {
                    const audioBlob = await response.blob();
                    const audio = new Audio();
                    audio.src = URL.createObjectURL(audioBlob);
    
                    // Change icon to "speaking"
                    speakButton.innerHTML = "<i class='fas fa-volume-up'></i>";
    
                    audio.play();
    
                    // Change icon back to "volume up" when done
                    audio.onended = () => {
                        speakButton.innerHTML = "<i class='fas fa-volume-up'></i>";
                    };
                } else {
                    console.error("Error synthesizing speech:", await response.text());
                    speakButton.innerHTML = "<i class='fas fa-volume-up'></i>"; // Reset icon on error
                }
            } catch (error) {
                console.error("Error:", error);
                speakButton.innerHTML = "<i class='fas fa-volume-up'></i>"; // Reset icon on error
            }
        }
    
        async function handleUserInput() {
            const message = userInput.value.trim();
            if (message) {
                addMessage(message, true);
                userInput.value = '';
                userInput.disabled = true;
                sendButton.disabled = true;
    
                try {
                    const response = await getAIResponse(message);
                    addMessage(response, false);
                } catch (error) {
                    addMessage("I'm having trouble connecting right now. Please try again later.🤖", false);
                    console.error("Error:", error);
                } finally {
                    userInput.disabled = false;
                    sendButton.disabled = false;
                    userInput.focus();
                }
            }
        }
    
        sendButton.addEventListener('click', handleUserInput);
        userInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') handleUserInput();
        });
    
        // Initialize highlight.js after page load
        document.addEventListener('DOMContentLoaded', () => {
            // Configure highlight.js
            hljs.configure({
                languages: ['javascript', 'python', 'html', 'css', 'php']
            });
            
            // Add an initial bot message
            addMessage("Hi there! I'm the PSU ChatBot. How can I help you with information about Pangasinan State University?", false);
            
            // Initialize any existing code blocks
            document.querySelectorAll('pre code').forEach((block) => {
                hljs.highlightBlock(block);
            });
        });
    
        // Observer to highlight dynamically added code blocks
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.addedNodes.length) {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1) { // Element node
                            const codeBlocks = node.querySelectorAll('pre code');
                            if (codeBlocks.length) {
                                codeBlocks.forEach((block) => {
                                    hljs.highlightBlock(block);
                                });
                            }
                        }
                    });
                }
            });
        });
    
        // Start observing the chat messages container
        observer.observe(document.getElementById('chat-messages'), {
            childList: true,
            subtree: true
        });
    </script>
</body>
</html>