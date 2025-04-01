@section('title', 'PSU Chatbot')
<x-users-layout>
    <x-slot name="header" class="bg-yellow-900">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PSU Chatbot') }} <ion-icon name="logo-reddit"></ion-icon>
        </h2>
    </x-slot>

    <div class="pt-3">
        <div class="container mx-auto">
            <div class="flex justify-center">
                <div class="w-full md:w-full lg:w-1/2 bg-white rounded-lg p-6">
                    <div id="chat-container" style="height: 80vh;">
                        <div class="bida">
                            <center>
                                <img src="{{ asset('images/bot.png') }}" class="botImage mb-5" alt="" id="botImage">
                                <div id="disappear">
                                    <h1 style="color: #37474f; user-select: none; margin-bottom: 10px;">The First PSU ChatBot</h1>
                                    <p style="margin-top: -10px; color: #607d8b; user-select: none;">Made possible by one of a kind students in <br>Pangasinan State University San Carlos City Campus</p>
                                </div>
                            </center>
                        </div>
                        <div id="chat-messages" class="p-5" style="max-height: 70vh;"></div>
                    </div>
                    <div class="flex gap-2 mt-3 relative items-center ">
                        <input type="text" id="user-input" class="w-full px-6" placeholder="Type your message..." autofocus>
                        <button onclick="handleUserInput()" class="absolute right-0 text-3xl items-center flex">
                            <ion-icon name="send"></ion-icon>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to populate the voice selection dropdown
    function populateVoiceList() {
        const voiceSelect = document.getElementById('voiceSelect');
        const voices = window.speechSynthesis.getVoices();

        // Clear existing options
        voiceSelect.innerHTML = '<option value="">Select Voice</option>';

        // Populate the dropdown with available voices
        voices.forEach((voice, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = `${voice.name} (${voice.lang})`;
            voiceSelect.appendChild(option);
        });
    }

    // Fetch voices asynchronously (since voices may load after page load)
    if ('speechSynthesis' in window) {
        window.speechSynthesis.onvoiceschanged = populateVoiceList;
    }
    </script>

</x-users-layout>
<script>
    var userProfilePicture = "{{ asset(Auth::user()->profile_picture) }}";
    var copyImage = '<ion-icon name="copy-outline"></ion-icon>';
    var botProfilePicture = "{{ asset('images/botbot.png') }}";

    const lastInput = document.getElementById("user-input").value;

    let previousQueries = new Set();

    function processQuery(query) {
        const lowerCaseQuery = query.toLowerCase();

        const responses = [
            { pattern: /hello|hi|good morning|hey/, response: "Hey! How can I help you today? Do you need anything?\n\n" },
            { pattern: /how are you|doing|going|kamusta/, response: "I'm doing great! How can I help you today?\n\n" },
            { pattern: /weather/, response: "The weather today is sunny." },
            { pattern: /haha/, response: "I'm glad that it made you laugh. If you need something else, feel free to ask!\n\n" },
            { pattern: /joke/, response: "Why don't scientists trust atoms? Because they make up everything!\n\n" },
            { pattern: /president/, response: "The president of the United States is currently Joe Biden.\n\n" },
            { pattern: /2 \+ 2/, response: "2 + 2 equals 4.\n\n" },
            { pattern: /thank/, response: "You're welcome! If you have any other questions or need assistance, please let me know.\n\n" },
            { pattern: /great/, response: "That's awesome to hear! Is there anything specific you're excited about or want to talk about?\n\n" },
            { pattern: /psu.*mission|their.*mission|mission.*psu/, response: 'Sure! Here\'s the Pangasinan State University\'s latest mission.\n\n"The Pangasinan State University, shall provide a human-centric, resilient, and sustainable academic environment to produce dynamic, responsive, and future-ready individuals capable of meeting the requirements of the local and global communities and industries."\n\n' },
            { pattern: /psu.*vision|their.*vision|vision.*psu/, response: 'Sure! Here\'s the Pangasinan State University\'s latest vision:\n\n"To be a leading industry-driven State University in the ASEAN region by 2030."\n\n' },
            { pattern: /psu.*vmgo|vmgo.*psu/, response: 'Here\'s the PSU\'s updated VMGO: \n\n**Vision**\n"To be a leading industry-driven State University in the ASEAN region by 2030."\n\n**Mission**\n"The Pangasinan State University, shall provide a human-centric, resilient, and sustainable academic environment to produce dynamic, responsive, and future-ready individuals capable of meeting the requirements of the local and global communities and industries." \n\n**Strategic Goals** \n**• SG 1**: Industry-Focused and Innovation-Based Student Learning and Development. \n**• SG 2**: Responsive and Sustainable Research, Community Extension, and Innovative Program. \n**• SG 3**: Effective and Efficient Governance and Financial Management. \n**• SG 4**: High-Performing and Engaged Human Resource. \n**• SG 5**: Strategic and Functional Internationalization Program. \n\nThis is the current VMGO of Pangasinan State University. If you have more concerns, feel free to ask.🥰🤖\n\n' },
            { pattern: /good day/, response: "Good day to you as well!\n\n" },
            { pattern: /good evening/, response: "Good evening! I hope you're having a great night so far.\n\n" },
            { pattern: /good night/, response: "Good night! Sleep well and have pleasant dreams.\n\n" },
            { pattern: /how are you/, response: "As an AI assistant, I don't have feelings, but I'm operating properly and ready to assist you with any questions or tasks you may have.\n\n" },
            { pattern: /what can you do/, response: "As a campus AI assistant, I'm here to assist you with various tasks and provide information related to campus life. This includes helping you find information about admissions, academic programs, financial aid, campus events, student services, housing options, library resources, and more. If you have any specific questions or need assistance with anything related to campus activities or services, feel free to ask!\n\n" },
            { pattern: /tell me a story/, response: "Once upon a time, in a faraway land, there lived a brave knight who embarked on a quest to slay a fearsome dragon. After many trials and tribulations, the knight finally encountered the dragon in its lair. With sword in hand and determination in his heart, the knight engaged the dragon in a fierce battle. After a long and arduous fight, the knight emerged victorious, slaying the dragon and freeing the land from its terror. The knight's bravery and perseverance became the stuff of legends, inspiring generations to come.\n\n" },
            { pattern: /admission|admissions/, response: "Admissions for the upcoming academic year began on March 11, 2024, and will continue until September 15, 2024. To apply, please visit our university's official website and navigate to the admissions section. There, you'll find the application form, along with detailed instructions on the admission process, required documents, and deadlines. \n\nHere are some tips to enhance your application: \n\n1. Start the application process early to ensure you have enough time to gather all necessary documents and complete the required steps. \n\n2. Double-check your application form for accuracy and completeness before submission. \n\n3. Pay attention to admission deadlines and submit your application well before the deadline to avoid any last-minute issues. \n\n4. Take advantage of any available resources, such as informational sessions, campus tours, or guidance from admissions counselors, to learn more about our university and make informed decisions. \n\n5. Prepare for any required entrance exams or interviews in advance, and showcase your strengths and accomplishments during the process.\n\n" },
            { pattern: /music|song/, response: "I can't play music, but I can help you with information about music-related events on campus or resources available for music students. How can I assist you further?\n\n\n" },
            { pattern: /financial aid|scholarship|grant|loan|work-study/, response: "Our university offers various financial aid options, including scholarships, grants, loans, and work-study programs. For detailed information about financial aid opportunities and how to apply, please visit our financial aid office or check our university's official website.\n\n" },
            { pattern: /academic programs|courses|majors/, response: "We offer a wide range of academic programs across various disciplines, including arts, sciences, engineering, business, and more. You can explore our full list of academic programs on our university's official website or contact the academic affairs office for more information.\n\n" },
            { pattern: /campus life|clubs|organizations|events|sports|activities/, response: "Our university provides a vibrant campus life with numerous opportunities for student engagement, including clubs, organizations, cultural events, sports teams, and recreational activities. To learn more about campus life and available resources, please visit our student affairs office or check our university's official website.\n\n" },
            { pattern: /housing|dormitory|apartment|residence/, response: "Information about on-campus housing options, including dormitories, apartments, and residence halls, can be found on our university's official website. You can also contact the housing office for assistance with housing applications, room assignments, and related inquiries.\n\n" },
            { pattern: /student services|counseling|career services|advising|disability support|wellness|library|resources/, response: "Our university offers a variety of student services to support your academic and personal success, including counseling and wellness programs, career services, academic advising, disability support services, and more. For information about available student services and how to access them, please visit our student services center or check our university's official website.\n\n" },
            { pattern: /library|books|journals|databases|research/, response: "Our university library provides access to a vast collection of resources, including books, journals, databases, and multimedia materials to support your academic research and learning needs. You can visit the library in person or explore online resources through our library website. Additionally, librarians are available to assist you with research inquiries and accessing library resources.\n\n" },
            { pattern: /music|song/, response: "I can't play music, but I can help you with information about music-related events on campus or resources available for music students. How can I assist you further?\n\n" },



            
        ];

        // Check if the query has been asked before
        if (previousQueries.has(lowerCaseQuery)) {
            return "I've already provided a response to that. Can I assist you with anything else?\n\n";
        }

        for (const { pattern, response } of responses) {
            if (pattern.test(lowerCaseQuery)) {
                // Store the query for future reference
                previousQueries.add(lowerCaseQuery);
                return response;
            }
        }

        if (query.toLowerCase().includes("create ticket")) {
            var createTicket = document.getElementById("createTicket");
            var createTicketBG = document.getElementById("createTicketBG");
            if (createTicket) {
                createTicket.classList.add('appears');
                createTicket.classList.add('hidden');
            }
        } else {
            var createTicket = document.getElementById("createTicket");
            if (createTicket) {
                createTicket.classList.remove('hidden');
            }
        }
        
        return "I'm sorry, I didn't understand that. Can you please rephrase? Or consider submitting a ticket for your unique concern. Kindly hit the \"Create Ticket\" on the bottom right!🥰🤖<br><br>";
    }

    let isTyping = false;

    async function handleUserInput() {
        if (isTyping) return; 
        isTyping = true; 

        const userInput = document.getElementById("user-input").value.trim();
        if (userInput === "") {
            isTyping = false;
            return;
        }

        var botImages = document.getElementsByClassName("botImage");
        var botText = document.getElementById("disappear");
        for (var i = 0; i < botImages.length; i++) {
            var botImage = botImages[i];
            if (botImage.style.height !== "50px") {
                botImage.style.animation = "botUp 0.3s ease-out forwards";
                botImage.style.height = "50px";
                botText.style.display = "none";
            }
        }

        const chatMessages = document.getElementById("chat-messages");

        const userMessage = document.createElement("div");
        userMessage.classList.add('user-message');
        userMessage.innerHTML = "<b class='user-message'><img src='" + userProfilePicture + "' class='chatImage' alt=''>You</b><br>" + userInput + "<br><br>";
        document.getElementById("user-input").value = "";
        chatMessages.appendChild(userMessage);

        await sleep(1000);

        const response = processQuery(userInput);
        const botMessage = document.createElement("div");
        botMessage.classList.add('bot-message');
        botMessage.innerHTML = '<b><img src="images/PSU logo.png" class="chatImage" alt="">PSU Chatbot</b><br>';
        
        const responseContent = document.createElement("div");
        responseContent.classList.add('response-content');
        botMessage.appendChild(responseContent);

        chatMessages.appendChild(botMessage);

        await typeWriter(response, responseContent);
        isTyping = false; 

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

        function speakBOT() {
            const vol1 = document.getElementById('vol1');
            const spin1 = document.getElementById('spin1');

            // temporary only
            spin1.classList.remove('hidden');
            vol1.classList.add('hidden');

            // set an interval of 0.3s to turn everything back
            let speaking = false;

            setInterval(function() {
            if (!speaking) {
                speaking = true;
                speakText(responseContent.textContent);
                spin1.classList.add('hidden');
                vol1.classList.remove('hidden');    
            }
            }, 500);
            speaking = false;
        }

        // Create the Copy button with an icon
        const copyButton = document.createElement("button");
        copyButton.classList.add('primary-button');
        copyButton.innerHTML = "<i id='copy1' class='fas fa-copy'></i> <i id='check1' class='fas fa-check hidden'></i>";
        copyButton.onclick = () => copyToClipboard(responseContent.textContent);
        buttonContainer.appendChild(copyButton);

        // Create the Like button with an icon
        const likeButton = document.createElement("button");
        likeButton.classList.add('primary-button');
        likeButton.innerHTML = "<i class='fas fa-thumbs-up'></i>"; 
        likeButton.onclick = () => {
            likeButton.disabled = true;
            dislikeButton.disabled = true; 
        };
        buttonContainer.appendChild(likeButton);

        // Create the Dislike button with an icon
        const dislikeButton = document.createElement("button");
        dislikeButton.classList.add('primary-button');
        dislikeButton.innerHTML = "<i class='fas fa-thumbs-down'></i>"; 
        dislikeButton.onclick = () => {
            dislikeButton.disabled = true; 
            likeButton.disabled = true; 
            // Additional logic for handling dislike feedback (e.g., sending feedback to server)
        };
        buttonContainer.appendChild(dislikeButton);

        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function speakText(text) {
        if ('speechSynthesis' in window) {
            const speech = new SpeechSynthesisUtterance(text);
            const voices = window.speechSynthesis.getVoices();

            const markVoice = voices.find(voice => voice.name === 'Microsoft Mark - English (United States)');
            const ziraVoice = voices.find(voice => voice.name === 'Microsoft Zira - English (United States)');

            if (markVoice) {
                speech.voice = markVoice;
            } else {
                console.log('Microsoft Mark voice not found, using default voice.');
            }

            speech.lang = 'en-US'; 
            speech.rate = 1.5; 

            window.speechSynthesis.speak(speech);
        } else {
            alert('Sorry, your browser does not support text-to-speech.');
        }
    }


    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);

        const copy1 = document.getElementById('copy1');
        const check1 = document.getElementById('check1');

        // temporary only
        copy1.classList.add('hidden');
        check1.classList.remove('hidden');

        // set an interval of 0.3s to turn everything back
        setInterval(function() {
            check1.classList.add('hidden');
            copy1.classList.remove('hidden');    
        }, 2000);

    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function typeWriter(text, element) {
        let index = 0;
        let isBold = false;
        let currentWord = "";

        while (index < text.length) {
            if (text.substr(index, 2) === '**') {
                if (isBold) {
                    element.innerHTML += `<b>${currentWord}</b>`;
                    currentWord = "";
                } else {
                    if (currentWord) {
                        element.innerHTML += currentWord;
                        currentWord = "";
                    }
                }
                isBold = !isBold;
                index += 2;
            } else if (text.substr(index, 4) === '<br>') {
                element.innerHTML += currentWord + '<br>';
                currentWord = "";
                index += 4;
                await sleep(50); // Longer pause for line breaks
            } else if (text[index] === '\n') {
                element.innerHTML += currentWord + '<br>';
                currentWord = "";
                index++;
                await sleep(50); // Longer pause for line breaks
            } else if (text[index] === ' ') {
                if (isBold) {
                    currentWord += text[index];
                } else {
                    element.innerHTML += currentWord + text[index];
                    currentWord = "";
                    await sleep(5);
                }
                index++;
            } else {
                currentWord += text[index];
                if (!isBold) {
                    element.innerHTML += text[index];
                    currentWord = "";
                    await sleep(5);
                }
                index++;
            }
            element.scrollTop = element.scrollHeight;
        }

        // Add any remaining text
        if (currentWord) {
            element.innerHTML += currentWord;
        }
    }


    document.getElementById("user-input").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            handleUserInput();
        }
    });


</script>

<style>
    #chat-container {
        margin: 0 auto;
        padding: 30px 10px 30px 30px;
        border: 1px solid #37474f;
        border-radius: 5px;
        background-color: #f9f9f9;
        overflow-y: auto; 
        font-size: 15px;
    }
    
    #chat-container::-webkit-scrollbar {
        width: 5px;
    }
    #chat-container::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, .3);
        border-radius: 15px;
    }
    #chat-messages {
        margin-bottom: 10px;
        width: 100%;
    }
    
    #user-input {
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #37474f;
        border-radius: 5px;
        font-size: 15px;
    }
    
    .chatImage {
        border-radius: 15px;
        height: 20px;
        margin-right: 10px;
        margin-left: -30px;
        margin-bottom: -20px;
        pointer-events: none;
        user-select: none;
    }
    .botImage {
        transition: height 0.3s ease;
        height: 250px;
        pointer-events: none;
        user-select: none;
        animation: botDown 0.3s ease-in-out;
    }
    
    @keyframes typing {
        from {
            width: 0;
        }
    }
    .typing-animation {
        animation: typing 1s steps(40, end);
    }
    
    @keyframes botUp {
        0% {
            height: 250px;
        } 
        100% {
            height: 50px;
        }
    }
    @keyframes botDown {
        100% {
            height: 250px;
        } 
        0% {
            height: 50px;
        }
    }



    .user-message {
        padding-top: 10px;
    }

    .bot-message {
        position: relative;
        padding-bottom: 10px;
    }

    .copy-button {
        position: absolute;
        right: left;
        bottom: -10px;
        padding: 5px 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .copy-button:hover {
        background-color: #45a049;
    }

    .copy-button:active {
        background-color: #3b8b3f;
    }


    .button-container {
        display: flex;
        gap: 15px; /* Space between buttons */
        justify-content: flex-start; /* Align buttons to the left (or center, if you want) */
        position: absolute;
        bottom: 5px;
        left: 0;
    }

    .primary-button {
        height: 25px !important;
        width: 25px !important;
        justify-content: center;
        color:rgba(0, 0, 0, .5);
        border: none;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center; /* Align icon and text vertically */
        transition: background-color 0.3s ease;
    }

    .primary-button:hover {
        background-color: #e4e7ff;
    }
</style>
