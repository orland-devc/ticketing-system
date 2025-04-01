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
    userMessage.innerHTML =  userInput + "<br>";
    document.getElementById("user-input").value = "";
    chatMessages.appendChild(userMessage);

    await sleep(1000);

    const response = processQuery(userInput);
    const botMessage = document.createElement("div");
    botMessage.classList.add('bot-message');
    botMessage.innerHTML = "<img src='" + botProfilePicture + "' class='chatImage' alt=''>";
    
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

    // Create the Retry button with an icon
    // const retryButton = document.createElement("button");
    // retryButton.classList.add('primary-button');
    // retryButton.innerHTML = "<i class='fas fa-redo'></i>"; 
    // retryButton.onclick = () => {
    //     botMessage.remove(); 
    //     userMessage.remove();

    //     document.getElementById('user-input').value = userInput;
    //     handleUserInput();
    // };
    // buttonContainer.appendChild(retryButton);

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
