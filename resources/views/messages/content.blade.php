<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Messages') }}
        <ion-icon name="chatbubbles" class="ml-3 text-2xl -mt-2"></ion-icon>
    </h2>
</x-slot>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .custom-ok-button {
        background-color: #0077b6 !important; /* Custom background color */
        color: white !important; /* Custom text color */
        border: none !important; /* Remove any default border */
    }

    .custom-ok-button:hover {
        background-color: #005f93 !important; /* Custom hover background color */
        color: white !important; /* Ensure text remains visible on hover */
    }

    #messageContent[contenteditable=true]:empty:before {
        content: attr(data-placeholder);
        color: #888;
    }
    
    .attachment-preview {
        position: relative;
        display: inline-block;
        margin: 4px;
    }
    
    .attachment-preview img {
        max-width: 100px;
        max-height: 100px;
        border-radius: 4px;
    }
    
    .remove-attachment {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
    }
    
    .file-preview {
        display: flex;
        align-items: center;
        padding: 8px;
        background: #f3f4f6;
        border-radius: 4px;
        margin: 4px;
    }
    
    .file-preview ion-icon {
        font-size: 24px;
        margin-right: 8px;
    }
    

</style>

<div class="py-12 max-md:py-0 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
            <div class="flex h-[80vh]">


                <!-- Chat List -->
                <div class="chat-list w-1/3 border-gray-200">
                    <div class="flex items-center justify-between p-6">
                        <h3 class="text-2xl font-bold text-gray-800">Chats</h3>
                        <a id="new_contact" href="javascript:void(0);" class="flex items-center justify-center hover:bg-blue-100 h-10 w-10 rounded-full" onclick="startNewChat()">
                            <ion-icon name="create-outline" class="text-2xl"></ion-icon>
                        </a>
                    </div>

                    <div id="newContactForm" class="hidden px-6 mb-4">
                        <input type="text" id="searchUserInput" class="w-full px-4 py-2 rounded-xl outline-none border-none shadow-sm focus:ring-1 focus:ring-indigo-500 transition-all bg-gray-100" placeholder="Search users...">
                        <ul id="searchResults" class="mt-2 bg-white rounded-xl shadow-lg max-h-60 overflow-y-auto"></ul>
                    </div>
                

                    <div class="flex">
                        <input type="text" id="searchInput" class="flex-1 mx-6 px-4 py-2 rounded-xl outline-none border-none shadow-sm focus:ring-1 focus:ring-indigo-500 transition-all bg-gray-100" placeholder="Search contacts...">

                        <div id="showWhenActive" class="hidden absolute top-14 bg-white w-full rounded-xl shadow-lg overflow-y-auto h-[calc(78vh-7.8rem)]">
                            @foreach ($sortedUsers as $search)
                                <div class="chat cursor-pointer py-4 px-6 hover:bg-indigo-100 transition ease-in-out duration-200" data-user-id="{{ $search->id }}">
                                    <div class="flex items-center">
                                        @if (!empty($search->profile_picture))
                                            <img src="{{ $search->profile_picture }}" alt="Profile Picture" class="w-10 h-10 rounded-full mr-4">
                                        @else
                                            <img src="{{ asset('images/uploads/default.jpg') }}" alt="Profile Picture" class="w-10 h-10 rounded-full mr-4">
                                        @endif

                                        <div class="flex-grow">
                                            <p class="font-semibold text-gray-900">{{ $search->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    
                    <div id="chatList" class="overflow-y-auto h-[calc(78vh-7.8rem)] mt-4 bg-white">
                        @foreach ($chats as $chat)
                            @if (!empty($chat->latest_message->created_at))
                                @php
                                    $chatPartner = ($chat->user_one == Auth::id()) ? $chat->userTwo : $chat->userOne;
                                @endphp
                                <div class="chat cursor-pointer hover:bg-indigo-100 transition ease-in-out duration-200 py-4 px-6" onclick="loadChat({{ $chat->id }}, {{ $chatPartner->id }})" data-chat-partner="{{ strtolower($chatPartner->name) }}">
                                    <div class="flex items-center">
                                        @if (!empty($chatPartner->profile_picture))
                                            <img src="{{ $chatPartner->profile_picture }}" alt="Profile Picture" class="w-12 h-12 rounded-full mr-4">
                                        @else
                                            <img src="{{ asset('images/uploads/default.jpg') }}" alt="Profile Picture" class="w-12 h-12 rounded-full mr-4">
                                        @endif
                    
                                        <div class="flex-grow">
                                            <p class="font-semibold text-gray-900 ">{{ Str::limit($chatPartner->name, 18) }}</p>
                                            @if ($chat->latest_message->sender_id == Auth::id())
                                                <p class="text-sm text-gray-500 truncate">You: {{ Str::limit($chat->latest_message->content ?? 'No messages yet', 20) }}</p>
                                            @else 
                                                <p class="text-sm text-gray-500 truncate">{{ Str::limit($chat->latest_message->content ?? 'No messages yet', 20) }}</p>
                                            @endif
                                        </div>
                                        @if (!empty($chat->latest_message->created_at))
                                            <small class="text-xs text-gray-400">{{ $chat->latest_message->created_at->diffForHumans() }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div id="noResults" class="hidden py-4 px-6 text-center text-gray-500">
                            No results found for "<span id="searchTerm"></span>"
                        </div>
                    </div>
                </div>

                <!-- Chat Box -->
                <div class="chat-box flex-grow flex flex-col relative border-l-2">
                    <div class="messages flex-grow bg-white overflow-y-auto">
                        <div id="newContactForm" class="hidden absolute bg-white shadow-lg p-4 rounded-lg w-1/2 max-w-md z-50">
                            <input type="text" id="searchUserInput" class="w-full p-2 border rounded-lg" placeholder="Search for users...">
                            <ul id="searchResults" class="mt-4"></ul>
                        </div>
                        <div id="contactInfo" class="hidden flex items-center justify-between text-xl font-semibold text-gray-800 px-6 py-2 shadow-sm">
                            <div class="flex items-center pt-2">
                                <div id="contactProfilePicture" class="w-10 h-10 rounded-full mr-4 flex items-center justify-center text-indigo-600 font-semibold text-lg"></div>
                                <span id="contactName"></span>
                            </div>

                            <div class="flex items-center w-20 justify-between">
                                <ion-icon name="search" class="text-2xl text-indigo-600 cursor-pointer hover:text-indigo-400"></ion-icon>
                                <ion-icon name="arrow-forward-outline" class="text-3xl text-indigo-600 cursor-pointer hover:text-indigo-400"></ion-icon>
                            </div>
                        </div>

                        <div id="messageList" class="scrollable-container px-6 pt-4">
                            <p class="text-gray-500 text-center py-4">Select a chat to view messages...</p>
                        </div>

                        <!-- Send Message -->
                        <div class="send-message w-full absolute bottom-0 left-0 p-4 bg-gray-200">
                            <form id="sendMessageForm" onsubmit="sendMessage(event)" class="flex flex-col">
                                <input type="hidden" id="currentChatId" value="">
                                <input type="hidden" id="currentChatPartnerId" value="">
                                
                                <!-- File Preview Area -->
                                <div id="filePreviewArea" class="hidden mb-1">
                                    <div id="attachmentPreviews" class="flex flex-wrap gap-2 max-h-32 overflow-y-auto px-2 pt-1"></div>
                                </div>
                        
                                <div class="w-full flex items-center relative">
                                    <!-- File Input (hidden) -->
                                    <input type="file" id="attachmentInput" name="attachments" multiple class="hidden" accept="*/*">
                                    
                                    <!-- Add File Button -->
                                    <button type="button" class="send-button text-3xl absolute left-2" onclick="document.getElementById('attachmentInput').click()">
                                        <ion-icon name="attach-outline"></ion-icon>
                                    </button>
                                    
                                    <!-- Message Input -->
                                    <div id="messageContent" 
                                         contenteditable="true" 
                                         class="w-full bg-white mx-16 px-4 py-2 border rounded-2xl max-h-16 overflow-auto focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-text"
                                         placeholder="Type your message or drop files here..."
                                         data-placeholder="Type your message or drop files here..."></div>
                                    
                                    <!-- Send Button -->
                                    <button type="submit" class="send-button text-xl absolute right-2">
                                        <ion-icon name="send"></ion-icon>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="imageTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 flex items-center justify-center py-8" style="display: none; backdrop-filter: blur(5px);">
    <div class="absolute text-3xl grid grid-cols-2 gap-6" style="top: 20px; right:20px">
        <a href="#" onclick="downloadImage()" class="font-bold text-gray-300 hover:text-white hover:bg-gray-600 p-2 rounded-full w-12 h-12 transition-all duration-200">
            <ion-icon class="text-gray-300 hover:text-white" name="download-outline"></ion-icon>
        </a>
        <a href="#" onclick="hideImageTab()" class="font-bold text-gray-300 hover:text-white hover:bg-gray-600 p-2 rounded-full w-12 h-12 transition-all duration-200">
            <ion-icon name="close"></ion-icon>
        </a>
    </div>
    <div id="imageNavigation">
        <a href="#" onclick="prevImage()" class="text-6xl text-gray-400 hover:text-white font-bold absolute" style="top: 45%; left: 20px">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
        <a href="#" onclick="nextImage()" class="text-6xl text-gray-400 hover:text-white font-bold absolute" style="top: 45%; right: 20px">
            <ion-icon name="chevron-forward-outline"></ion-icon>
        </a>
    </div>
    <img id="imagePreview" src="" alt="" class="h-[80vh]">
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let autoRefresh;



    document.getElementById('messageContent').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            // If Shift + Enter is pressed, allow new line
            if (event.shiftKey) {
                return; // Default behavior (new line) will occur
            }
            
            // If only Enter is pressed, prevent new line and send message
            event.preventDefault();
            
            // Get the form and submit it
            const form = document.getElementById('sendMessageForm');
            form.dispatchEvent(new Event('submit'));
        }
    });



    function startNewChat() {
        // Clear the main content
        document.getElementById('messageList').innerHTML = '<p class="text-gray-500 text-center py-4">Start a new chat by searching for a user...</p>';

        // Show the new contact form and focus on the input
        const newContactForm = document.getElementById('newContactForm');
        newContactForm.classList.remove('hidden');
        document.getElementById('searchUserInput').focus();

        // Clear previous results
        document.getElementById('searchResults').innerHTML = '';
    }

    // Event delegation for dynamically generated list items
    document.getElementById('searchResults').addEventListener('click', function(event) {
        const clickedElement = event.target.closest('li');
        
        if (clickedElement) {
            const userId = clickedElement.getAttribute('data-user-id');
            const userName = clickedElement.textContent;

            if (userId) {
                selectUser(userId, userName);
            }
        }
    });

    function displaySearchResults(users) {
        const resultsContainer = document.getElementById('searchResults');
        resultsContainer.innerHTML = ''; // Clear previous results

        if (users.length > 0) {
            users.forEach(user => {
                const listItem = document.createElement('li');
                listItem.textContent = user.name;
                listItem.classList.add('cursor-pointer', 'hover:bg-blue-100', 'p-2', 'rounded-lg');
                listItem.setAttribute('data-user-id', user.id);

                resultsContainer.appendChild(listItem);
            });
        } else {
            resultsContainer.innerHTML = '<p class="p-2">No users found.</p>';
        }
    }

    document.getElementById('searchUserInput').addEventListener('input', function() {
        const query = this.value.trim();

        if (query === '') {
            document.getElementById('searchResults').innerHTML = '';
            return;
        }

        fetch(`/search-users?query=${query}`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(users => {
            displaySearchResults(users);
        });
    });



    let isInitialLoad = false;

    function loadChat(chatId, chatPartnerId) {
        isInitialLoad = true;
        const contactInfo = document.getElementById('contactInfo');

        contactInfo.classList.remove('hidden');

        document.getElementById('currentChatId').value = chatId;
        document.getElementById('currentChatPartnerId').value = chatPartnerId;
        fetchChatMessages(chatId);

        // Update contact name
        const chatElement = document.querySelector(`.chat[data-user-id="${chatPartnerId}"]`);
        const contactName = document.querySelector(`.chat[data-user-id="${chatPartnerId}"] .font-semibold`).textContent;
        document.getElementById('contactName').textContent = contactName;

        const profilePictureElement = chatElement.querySelector('img');
        const contactProfilePicture = document.getElementById('contactProfilePicture');

        contactProfilePicture.innerHTML = `<img src="${profilePictureElement.src}" alt="Profile Picture" class="w-10 h-10 rounded-full">`;

        if (autoRefresh) {
            clearInterval(autoRefresh);
        }

        // Set auto-refresh every 1 second
        autoRefresh = setInterval(() => {
            fetchChatMessages(chatId);
        }, 1000);
    }

    function fetchChatMessages(chatId) {
        const messageList = document.getElementById('messageList');
        const isScrolledToBottom = messageList.scrollHeight - messageList.scrollTop <= messageList.clientHeight + 100; // Adding a small threshold

        fetch(`/chats/${chatId}/messages`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(messages => {
            messageList.innerHTML = '';
            messages.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message');
                if (message.sender_id == {{ Auth::id() }}) {
                    messageDiv.classList.add('user-message');
                } else {
                    messageDiv.classList.add('bot-message');
                }
                
                // Add message content
                if (message.content) {
    const nl2br = (str) => str.replace(/\n/g, '<br>');
    messageDiv.innerHTML = `<div class="py-2 px-4"><span class="content">${nl2br(message.content)}</span></div>`;
}

                
                
                // Add attachments if any
                if (message.attachments && message.attachments.length > 0) {
                    const attachmentsDiv = document.createElement('div');
                    attachmentsDiv.classList.add('attachments');
                    message.attachments.forEach(attachment => {
                        const fileExtension = attachment.file_name.split('.').pop().toLowerCase();
                        
                        if (message.attachments && message.attachments.length > 0) {
                            const attachmentsDiv = document.createElement('div');
                            attachmentsDiv.classList.add('attachments');
                            message.attachments.forEach((attachment, index) => {
                                const fileExtension = attachment.file_name.split('.').pop().toLowerCase();
                                
                                if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension)) {
                                    const img = document.createElement('img');
                                    img.src = attachment.file_location;
                                    img.alt = attachment.file_name;
                                    img.classList.add('attachment-image');
                                    img.onclick = () => viewImage(attachment.file_location, attachment.file_name, index);
                                    attachmentsDiv.appendChild(img);
                                } else {
                                    const link = document.createElement('a');
                                    link.href = attachment.file_location;
                                    link.textContent = attachment.file_name;
                                    link.target = '_blank';
                                    attachmentsDiv.appendChild(link);
                                }
                            });
                            messageDiv.appendChild(attachmentsDiv);
                        }
                    });
                    messageDiv.appendChild(attachmentsDiv);
                }
                
                messageList.appendChild(messageDiv);
            });

            if (isInitialLoad || isScrolledToBottom) {
                messageList.scrollTop = messageList.scrollHeight;
            }
            
            isInitialLoad = false;
        });
    }



    function sendMessage(event) {
        event.preventDefault();

        const chatId = document.getElementById('currentChatId').value;
        const chatPartnerId = document.getElementById('currentChatPartnerId').value;
        const content = document.getElementById('messageContent').innerText;
        document.getElementById('messageContent').innerText = '';
        
        if ((!content && attachments.files.length === 0) || (!chatId && !chatPartnerId)) {
            Swal.fire({
                title: 'Oops!',
                text: 'Please enter a message or attach a file',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'custom-ok-button'
                }
            });
            return;
        }

        const formData = new FormData();
        formData.append('chat_id', chatId);
        formData.append('sender_id', {{ Auth::id() }});
        formData.append('receiver_id', chatPartnerId);
        formData.append('content', content);
        
        
        // Append attachments
        for (let file of attachments.files) {
            formData.append('attachments[]', file);
        }

        const url = chatId ? '/chats/message' : '/chats/start-new-chat';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.chat_id) {
                document.getElementById('currentChatId').value = data.chat_id;
            }
            // Clear message and attachments
            document.getElementById('messageContent').innerText = '';
            attachments = new DataTransfer();
            updateAttachmentPreviews();
            updateFileInput();
            
            loadChat(data.chat_id, chatPartnerId);
        });
    }

    // New function to handle user selection from search
    function selectUser(userId, userName) {
        fetch(`/chats/get-or-create/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.chat) {
                loadChat(data.chat.id, userId);  // Load existing chat
            } else {
                // Clear the message list and set up a new chat
                document.getElementById('messageList').innerHTML = `<p class="text-gray-500 text-center py-4">Starting chat with ${userName}. Type your message below to begin...</p>`;
                document.getElementById('currentChatPartnerId').value = userId;

                // Update contact info
                const contactInfo = document.getElementById('contactInfo');
                contactInfo.classList.remove('hidden');
                document.getElementById('contactName').textContent = userName;
                document.getElementById('contactProfilePicture').innerHTML = '<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">' + userName.charAt(0).toUpperCase() + '</div>';
            }

            document.getElementById('newContactForm').classList.add('hidden');  // Hide the new contact form
            document.getElementById('searchUserInput').value = '';  // Clear the search input
        });
    }

    // Add click event listeners to search results
    document.querySelectorAll('#showWhenActive .chat').forEach(chat => {
        chat.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            selectUser(userId);
        });
    });


    function openAddFile() {
        const addFileArea = document.getElementById('addFileArea');
        const addFile = document.getElementById('addFile');

        if (addFileArea.classList.contains('hidden')) {
            addFileArea.classList.remove('hidden', 'animated-closesss');
            addFileArea.classList.add('animated-pulsesss');

            addFile.classList.remove('animated-rotate-back'); 
            addFile.classList.add('animated-rotate');
        } else {
            addFileArea.classList.remove('animated-pulsesss');
            addFileArea.classList.add('animated-closesss');

            addFile.classList.remove('animated-rotate'); 
            addFile.classList.add('animated-rotate-back');

            setTimeout(() => {
                addFileArea.classList.add('hidden');
                addFile.classList.remove('animated-rotate-back'); 
            }, 200);
        }
    }


    // search 
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const chatList = document.getElementById('chatList');
        const chats = chatList.getElementsByClassName('chat');
        const noResults = document.getElementById('noResults');
        const searchTermSpan = document.getElementById('searchTerm');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let resultsFound = false;

            Array.from(chats).forEach(chat => {
                const chatPartnerName = chat.getAttribute('data-chat-partner');
                if (chatPartnerName.includes(searchTerm)) {
                    chat.style.display = '';
                    resultsFound = true;
                } else {
                    chat.style.display = 'none';
                }
            });

            if (!resultsFound && searchTerm !== '') {
                noResults.style.display = 'block';
                searchTermSpan.textContent = searchTerm;
            } else {
                noResults.style.display = 'none';
            }
        });
    });

    let currentIndex = 0;
    let attachments = [];
    let fileNames = [];

    function viewImage(imageUrl, fileName, index) {
        const img = document.getElementById('imagePreview');
        img.src = imageUrl;
        img.alt = fileName;
        document.getElementById('imageTab').style.display = "flex";
        currentIndex = index;
        updateImageNavigation();
    }

    function hideImageTab() {
        document.getElementById('imageTab').style.display = "none";
    }

    function downloadImage() {
        const imageUrl = document.getElementById('imagePreview').src;
        const fileName = document.getElementById('imagePreview').alt;
        const link = document.createElement('a');
        link.href = imageUrl;
        link.download = fileName;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function prevImage() {
        currentIndex = (currentIndex === 0) ? attachments.length - 1 : currentIndex - 1;
        updateImageView();
    }

    function nextImage() {
        currentIndex = (currentIndex === attachments.length - 1) ? 0 : currentIndex + 1;
        updateImageView();
    }

    function updateImageView() {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = attachments[currentIndex];
        imagePreview.alt = fileNames[currentIndex];
        updateImageNavigation();
    }

    function updateImageNavigation() {
        const navigation = document.getElementById('imageNavigation');
        navigation.style.display = attachments.length > 1 ? 'block' : 'none';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideImageTab();
        } else if (event.key === 'ArrowLeft') {
            prevImage();
        } else if (event.key === 'ArrowRight') {
            nextImage();
        }
    });

    // Initialize the chat (replace 'chatId' with the actual chat ID)
    fetchChatMessages('chatId');

















    
    
</script>

<script>
    let attachments2 = new DataTransfer();
    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    
    // File Input Handler
    document.getElementById('attachmentInput').addEventListener('change', handleFileSelect);
    
    // Drag and Drop Handlers
    const messageInput = document.getElementById('messageContent');
    messageInput.addEventListener('dragenter', handleDragEnter);
    messageInput.addEventListener('dragover', handleDragOver);
    messageInput.addEventListener('dragleave', handleDragLeave);
    messageInput.addEventListener('drop', handleDrop);
    
    // Paste Handler
    messageInput.addEventListener('paste', handlePaste);
    
    function handleFileSelect(event) {
        const files = event.target.files;
        addFiles(files);
    }
    
    function handleDrop(event) {
        event.preventDefault();
        event.stopPropagation();
        
        messageInput.classList.remove('ring-2', 'ring-blue-500');
        const files = event.dataTransfer.files;
        addFiles(files);
    }
    
    function handlePaste(event) {
        const items = (event.clipboardData || event.originalEvent.clipboardData).items;
        const files = [];
        
        for (let item of items) {
            if (item.kind === 'file') {
                const file = item.getAsFile();
                files.push(file);
            }
        }
        
        if (files.length > 0) {
            event.preventDefault();
            addFiles(files);
        }
    }
    
    function addFiles(files) {
        for (let file of files) {
            attachments2.items.add(file);
        }
        updateFilePreviews();
    }
    
    function updateFilePreviews() {
        const previewArea = document.getElementById('filePreviewArea');
        const previewsContainer = document.getElementById('attachmentPreviews');
        previewsContainer.innerHTML = '';
        
        if (attachments2.files.length > 0) {
            previewArea.classList.remove('hidden');
            
            Array.from(attachments2.files).forEach((file, index) => {
                const preview = createFilePreview(file, index);
                previewsContainer.appendChild(preview);
            });
        } else {
            previewArea.classList.add('hidden');
        }
    }
    
    function createFilePreview(file, index) {
        const preview = document.createElement('div');
        preview.className = 'attachment-preview';
        
        if (validImageTypes.includes(file.type)) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            preview.appendChild(img);
        } else {
            const filePreview = document.createElement('div');
            filePreview.className = 'file-preview';
            filePreview.innerHTML = `
                <ion-icon name="document-outline"></ion-icon>
                <span>${file.name.substring(0, 20)}${file.name.length > 20 ? '...' : ''}</span>
            `;
            preview.appendChild(filePreview);
        }
        
        const removeButton = document.createElement('button');
        removeButton.className = 'remove-attachment';
        removeButton.innerHTML = '×';
        removeButton.onclick = () => removeFile(index);
        preview.appendChild(removeButton);
        
        return preview;
    }
    
    function removeFile(index) {
        const newAttachments = new DataTransfer();
        Array.from(attachments2.files)
            .filter((_, i) => i !== index)
            .forEach(file => newAttachments.items.add(file));
        attachments2 = newAttachments;
        updateFilePreviews();
    }
    
    function handleDragEnter(event) {
        event.preventDefault();
        messageInput.classList.add('ring-2', 'ring-blue-500');
    }
    
    function handleDragOver(event) {
        event.preventDefault();
    }
    
    function handleDragLeave(event) {
        event.preventDefault();
        messageInput.classList.remove('ring-2', 'ring-blue-500');
    }

    // Modify your existing sendMessage function to include file handling
    async function sendMessage(event) {
    event.preventDefault();
    
    const chatId = document.getElementById('currentChatId').value;
    const chatPartnerId = document.getElementById('currentChatPartnerId').value;
    const content = document.getElementById('messageContent').innerText.trim();
    
    // Changed condition to check if both content and attachments are empty
    if (content === '' && (!attachments2 || attachments2.files.length === 0)) {
        Swal.fire({
            title: 'Oops!',
            text: 'Please enter a message or attach a file',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'custom-ok-button'
            }
        });
        return;
    }
    
    // Check if we have required chat information
    if (!chatId && !chatPartnerId) {
        Swal.fire({
            title: 'Error',
            text: 'Chat information is missing',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'custom-ok-button'
            }
        });
        return;
    }
    
    const formData = new FormData();
    formData.append('chat_id', chatId);
    formData.append('sender_id', {{ Auth::id() }});
    formData.append('receiver_id', chatPartnerId);
    
    // Only append content if it's not empty
    if (content !== '') {
        formData.append('content', content);
    }
    
    // Append files if they exist
    if (attachments2 && attachments2.files.length > 0) {
        Array.from(attachments2.files).forEach(file => {
            formData.append('attachments2[]', file);
        });
    }
    
    try {
        const response = await fetch('/chats/message', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Clear message and attachments
            document.getElementById('messageContent').innerText = '';
            attachments2 = new DataTransfer();
            updateFilePreviews();
            
            // Refresh chat
            if (data.chat_id) {
                loadChat(data.chat_id, chatPartnerId);
            }
        } else {
            throw new Error(data.message || 'Please write something to send an attachment.');
        }
    } catch (error) {
        console.error('Error sending message:', error);
        Swal.fire({
            title: 'Error',
            text: error.message || 'Failed to send message. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'custom-ok-button'
            }
        });
    }
}
</script>