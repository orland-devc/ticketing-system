

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

