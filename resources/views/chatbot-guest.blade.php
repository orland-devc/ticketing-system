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
    <link rel="icon" href="{{ asset('images/PSU logo.png') }}" type="image/x-icon">
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
        var botProfilePicture = "{{ asset('images/botbot.png') }}";
        
        let previousQueries = new Set();

        function processQuery(query) {
            const lowerCaseQuery = query.toLowerCase();

            const responses = [
                { pattern: /hello|hi|good morning|hey/, response: "Hey! How can I help you today?" },
                { pattern: /how are you|doing|going|kamusta/, response: "I'm doing great! How can I help you today?" },
                { pattern: /weather/, response: "The weather today is sunny." },
                { pattern: /haha/, response: "I'm glad that it made you laugh. If you need something else, feel free to ask!" },
                { pattern: /joke/, response: "Why don't scientists trust atoms? Because they make up everything!" },
                { pattern: /president/, response: "The president of the United States is currently Joe Biden." },
                { pattern: /2 \+ 2/, response: "2 + 2 equals 4." },
                { pattern: /thank/, response: "You're welcome! If you have any other questions or need assistance, please let me know." },
                { pattern: /great/, response: "That's awesome to hear! Is there anything specific you're excited about or want to talk about?" },
                { pattern: /psu.*mission|their.*mission|mission.*psu/, response: 'Sure! Here\'s the Pangasinan State University\'s latest mission.\n\n"The Pangasinan State University, shall provide a human-centric, resilient, and sustainable academic environment to produce dynamic, responsive, and future-ready individuals capable of meeting the requirements of the local and global communities and industries."' },
                { pattern: /psu.*vision|their.*vision|vision.*psu/, response: 'Sure! Here\'s the Pangasinan State University\'s latest vision:\n\n"To be a leading industry-driven State University in the ASEAN region by 2030."\n\n' },
                { pattern: /psu.*vmgo|vmgo.*psu/, response: 'Here\'s the PSU\'s updated VMGO: \n\n**Vision**\n"To be a leading industry-driven State University in the ASEAN region by 2030."\n\n**Mission**\n"The Pangasinan State University, shall provide a human-centric, resilient, and sustainable academic environment to produce dynamic, responsive, and future-ready individuals capable of meeting the requirements of the local and global communities and industries." \n\n**Strategic Goals** \n**• SG 1**: Industry-Focused and Innovation-Based Student Learning and Development. \n**• SG 2**: Responsive and Sustainable Research, Community Extension, and Innovative Program. \n**• SG 3**: Effective and Efficient Governance and Financial Management. \n**• SG 4**: High-Performing and Engaged Human Resource. \n**• SG 5**: Strategic and Functional Internationalization Program. \n\nThis is the current VMGO of Pangasinan State University. If you have more concerns, feel free to ask.🥰🤖' },
                { pattern: /good day/, response: "Good day to you as well!" },
                { pattern: /good evening/, response: "Good evening! I hope you're having a great night so far." },
                { pattern: /good night/, response: "Good night! Sleep well and have pleasant dreams." },
                { pattern: /how are you/, response: "As an AI assistant, I don't have feelings, but I'm operating properly and ready to assist you with any questions or tasks you may have." },
                { pattern: /what can you do/, response: "As a campus AI assistant, I'm here to assist you with various tasks and provide information related to campus life. This includes helping you find information about admissions, academic programs, financial aid, campus events, student services, housing options, library resources, and more. If you have any specific questions or need assistance with anything related to campus activities or services, feel free to ask!" },
                { pattern: /tell me a story/, response: "Once upon a time, in a faraway land, there lived a brave knight who embarked on a quest to slay a fearsome dragon. After many trials and tribulations, the knight finally encountered the dragon in its lair. With sword in hand and determination in his heart, the knight engaged the dragon in a fierce battle. After a long and arduous fight, the knight emerged victorious, slaying the dragon and freeing the land from its terror. The knight's bravery and perseverance became the stuff of legends, inspiring generations to come." },
                { pattern: /admission|admissions/, response: "Admissions for the upcoming academic year began on March 11, 2024, and will continue until September 15, 2024. To apply, please visit our university's official website and navigate to the admissions section. There, you'll find the application form, along with detailed instructions on the admission process, required documents, and deadlines. \n\nHere are some tips to enhance your application: \n\n1. Start the application process early to ensure you have enough time to gather all necessary documents and complete the required steps. \n\n2. Double-check your application form for accuracy and completeness before submission. \n\n3. Pay attention to admission deadlines and submit your application well before the deadline to avoid any last-minute issues. \n\n4. Take advantage of any available resources, such as informational sessions, campus tours, or guidance from admissions counselors, to learn more about our university and make informed decisions. \n\n5. Prepare for any required entrance exams or interviews in advance, and showcase your strengths and accomplishments during the process." },
                { pattern: /music|song/, response: "I can't play music, but I can help you with information about music-related events on campus or resources available for music students. How can I assist you further?" },
                { pattern: /financial aid|scholarship|grant|loan|work-study/, response: "Our university offers various financial aid options, including scholarships, grants, loans, and work-study programs. For detailed information about financial aid opportunities and how to apply, please visit our financial aid office or check our university's official website." },
                { pattern: /academic programs|courses|majors/, response: "We offer a wide range of academic programs across various disciplines, including arts, sciences, engineering, business, and more. You can explore our full list of academic programs on our university's official website or contact the academic affairs office for more information." },
                { pattern: /campus life|clubs|organizations|events|sports|activities/, response: "Our university provides a vibrant campus life with numerous opportunities for student engagement, including clubs, organizations, cultural events, sports teams, and recreational activities. To learn more about campus life and available resources, please visit our student affairs office or check our university's official website." },
                { pattern: /housing|dormitory|apartment|residence/, response: "Information about on-campus housing options, including dormitories, apartments, and residence halls, can be found on our university's official website. You can also contact the housing office for assistance with housing applications, room assignments, and related inquiries." },
                { pattern: /student services|counseling|career services|advising|disability support|wellness|library|resources/, response: "Our university offers a variety of student services to support your academic and personal success, including counseling and wellness programs, career services, academic advising, disability support services, and more. For information about available student services and how to access them, please visit our student services center or check our university's official website." },
                { pattern: /library|books|journals|databases|research/, response: "Our university library provides access to a vast collection of resources, including books, journals, databases, and multimedia materials to support your academic research and learning needs. You can visit the library in person or explore online resources through our library website. Additionally, librarians are available to assist you with research inquiries and accessing library resources." },
            ];

            // Check if the query has been asked before
            if (previousQueries.has(lowerCaseQuery)) {
                return "I've already provided a response to that. Can I assist you with anything else?";
            }

            for (const { pattern, response } of responses) {
                if (pattern.test(lowerCaseQuery)) {
                    // Store the query for future reference
                    previousQueries.add(lowerCaseQuery);
                    return response;
                }
            }
            
            return "I'm sorry, I didn't understand that. Can you please rephrase? Or consider submitting a ticket for your unique concern. Kindly hit the \"Create Ticket\" on the bottom right!🥰🤖";
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

        // Add an initial bot message
        addMessage("Hello! How can I assist you today?", false);
    </script>
</body>
</html>