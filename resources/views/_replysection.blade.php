
<div id="replySection" class="hidden flex flex-start bg-white mb-4 p-6 rounded-xl border shadow-md text-gray-700 break-words">
    @if(Auth::check())
        @if(Auth::user()->profile_picture)
            <img src="{{ asset(Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="h-12 w-12 mr-4 rounded-full">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ Auth::user()->name }}" class="h-12 w-12 mr-4 rounded-full" style="border: 1px solid blue">
        @endif
    @else
        <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->guest_name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $ticket->guest_name }}" class="h-12 w-12 mr-4 rounded-full" style="border: 1px solid blue">
    @endif
    <div class="w-full">
        <div class="flex items-center gap-2 px-2 py-0 mt-3 mb-6 w-fit rounded-lg bg-blue-100 text-black">
            <p class="font-bold">Reply to:</p>
            {{ $ticket->user->name ?? $ticket->guest_name }}
        </div>
        <form action="{{ route('office.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" style="m-0 p-0">
            @csrf
            <div class="">
                <div id="editor" contenteditable="true" class="min-h-48 appearance-none p-3 rounded-lg text-gray-700 leading-tight border border-blue-200 focus:outline-blue-500" autofocus placeholder="Enter your reply"></div>
                <input type="hidden" name="content" id="hiddenContent">

                <div id="attachmentPreviews" class="flex flex-wrap gap-2 mt-2">
                    <!-- Attachment previews will be inserted here -->
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2">
                <input type="file" id="attachmentInput" name="attachments[]" class="hidden" multiple>
                <label for="attachmentInput" class="cursor-pointer">
                    <i class="fa-solid fa-paperclip text-xl text-blue-800 py-2 px-3 bg-blue-100 hover:bg-blue-300 rounded-full transition-all"></i>
                </label>
                <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500" type="submit">
                    <i class="fa-solid fa-paper-plane mr-2"></i>
                    Submit Reply
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showReplySection() {
        const replySection = document.getElementById('replySection');

        if (replySection.classList.contains('hidden')) {
            replySection.classList.remove('hidden');
            scrollToBottom();
        } else {
            replySection.classList.add('hidden');
        }
    }    
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        function fetchReplies() {
            $.get("{{ route('office.tickets.replies', $ticket->id) }}", function(data){
                $(".replies-container").html(data);
                scrollToBottom();
            });
        }

        function fetchUpdates() {
            $.get("{{ route('office.tickets.updates', $ticket->id) }}", function(data){
                $(".top-options").html(data);
            });
        }
        
        fetchUpdates();
        setInterval(fetchUpdates, 3000);
        fetchReplies();
        setInterval(fetchReplies, 3000);
        
        let attachments = new DataTransfer();

        function updateFileInput() {
            $('#attachmentInput').val('');
            $('#attachmentInput')[0].files = attachments.files;
        }

        function updateAttachmentPreviews() {
            $('#attachmentPreviews').empty();
            Array.from(attachments.files).forEach((file, index) => {
                let preview;
                let truncatedFileName = file.name.length > 8 ? file.name.substring(0, 8) + '...' : file.name;
                if (file.type.startsWith('image/')) {
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="${URL.createObjectURL(file)}" class="max-h-12 rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">&times;</button>
                    `);
                } else if (file.type === 'application/pdf') { // if PDF
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="{{ asset('images/PDF_icon2.png') }}" class="w-12 h-12 rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">&times;</button>
                    `);
                } else if (file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') { // if DOCX
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="{{ asset('images/docx_icon.png') }}" class="max-w-[100px] max-h-[100px] rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">&times;</button>
                    `);
                } else if (file.type === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') { // if PPTX
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="{{ asset('images/ppt_icon.png') }}" class="max-w-[100px] max-h-[100px] rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">&times;</button>
                    `);
                } else { // For other file types
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="{{ asset('images/file_icon.png') }}" class="max-w-[100px] max-h-[100px] rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">×</button>
                    `);
                }

                $('#attachmentPreviews').append(preview);
            });
        }

        function addFiles(files) {
            Array.from(files).forEach((file) => {
                attachments.items.add(file);
            });
            updateAttachmentPreviews();
            updateFileInput();
        }

        $('#attachmentInput').change(function(e) {
            addFiles(e.target.files);
        });

        $(document).on('click', '.remove-attachment', function() {
            const indexToRemove = parseInt($(this).data('index'));
            
            const newAttachments = new DataTransfer();
            Array.from(attachments.files)
                .filter((_, index) => index !== indexToRemove)
                .forEach(file => newAttachments.items.add(file));
            
            attachments = newAttachments;
            updateAttachmentPreviews();
            updateFileInput();
        });

        $('#editor').on('paste', function(e) {
            const clipboardData = e.originalEvent.clipboardData;
            if (!clipboardData || !clipboardData.items) return;

            const items = clipboardData.items;
            const files = [];

            for (let i = 0; i < items.length; i++) {
                if (items[i].kind === 'file') {
                    const file = items[i].getAsFile();
                    if (file) files.push(file);
                }
            }

            if (files.length > 0) {
                e.preventDefault();
                addFiles(files);
            }
        });

        $("form").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            var htmlContent = $('#editor').html();

            var plainText = htmlContent
                .replace(/<div><br><\/div>/g, '\n') 
                .replace(/<div>/g, '\n') 
                .replace(/<\/div>/g, '') 
                .replace(/<br>/g, '\n') 
                .replace(/&nbsp;/g, ' ')
                .trim();

            formData.set('content', plainText);

            formData.delete('attachments[]');
            for (let file of attachments.files) {
                formData.append('attachments[]', file);
            }

            $.ajax({
                url: $(this).attr("action"),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    fetchReplies();
                    $('#editor').html(''); 
                    attachments = new DataTransfer();
                    updateAttachmentPreviews();
                    updateFileInput();
                    scrollToBottom();
                    updateAIButton(); // Update button state after clearing editor
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred. Please try again.');
                }
            });
        });

        function scrollToBottom() {
            var repliesContainer = $(".autoScroll");
            repliesContainer.scrollTop(repliesContainer[0].scrollHeight);
        }

        $('#editor').on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (e.originalEvent.dataTransfer.files.length) {
                $('#attachmentInput')[0].files = e.originalEvent.dataTransfer.files;
                $('#attachmentInput').trigger('change');
            }
        });

        $('#editor').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });

        // Create a container for the AI button
        $('button[type="submit"]').before('<div id="aiButtonContainer" class="inline-block"></div>');
        $('button[type="submit"]').before('<span id="aiLoadingIndicator" class="hidden ml-2 text-blue-500"><i class="fa-solid fa-spinner fa-spin"></i> Generating...</span>');
        
        const API_KEY = "{{ env('API_KEY') }}";
        const MODEL = "{{ env('API_MODEL') }}";
        const AXIOS_POST = "{{ env('AXIOS_POST') }}";
        const botProfilePicture = "{{ asset('images/botbot.png') }}";
        
        let chatContext = [
            {
                "role": "system", 
                "content": "You are a helpful customer support assistant for Pangasinan State Univerity PSU's ticket system. Generate professional, friendly, and helpful responses to tickets. Address the recipient by name. Be concise and solution-focused. Don't make it too long to avoid TL;DR. Just make it direct and informative."
            }
        ];
        
        // Track button state
        let aiButtonState = 'suggestion'; // Can be 'suggestion' or 'expand'

        // Function to update button state based on editor content
        function updateAIButton() {
            const editorContent = $('#editor').text().trim();
            const buttonContainer = $('#aiButtonContainer');
            
            if (editorContent === '') {
                if (aiButtonState !== 'suggestion') {
                    aiButtonState = 'suggestion';
                    buttonContainer.html(`
                        <button id="getAISuggestion" type="button" class="ml-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <i class="fa-solid fa-magic mr-2"></i>
                            Get AI Suggestion
                        </button>
                    `);
                }
            } else {
                if (aiButtonState !== 'expand') {
                    aiButtonState = 'expand';
                    buttonContainer.html(`
                        <button id="expandAIContent" type="button" class="ml-2 bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <i class="fa-solid fa-expand mr-2"></i>
                            Expand
                        </button>
                    `);
                }
            }
        }

        // Set initial button state
        updateAIButton();

        // Monitor editor content changes
        $('#editor').on('input', function() {
            updateAIButton();
        });

        // Event delegation for both buttons
        $(document).on('click', '#getAISuggestion, #expandAIContent', async function() {
            const buttonId = $(this).attr('id');
            const isExpand = buttonId === 'expandAIContent';
            
            $('#aiLoadingIndicator').removeClass('hidden');
            $(this).addClass('opacity-50 cursor-not-allowed').prop('disabled', true);
            
            const recipientName = '{{ $ticket->user->name ?? $ticket->guest_name }}';
            const ticketCategory = '{{ $ticket->category }}';
            const ticketSubject = '{{ $ticket->subject }}';
            const ticketContent = `{{ preg_replace('/\r\n|\r|\n/', ' ', strip_tags($ticket->content)) }}`;
            
            let previousConversation = '';
            @if(isset($ticket->replies) && count($ticket->replies) > 0)
                @foreach($ticket->replies as $reply)
                    previousConversation += '{{ $reply->user ? $reply->user->name : ($reply->is_from_guest ? $ticket->guest_name : "Support Agent") }}: {{ preg_replace('/\r\n|\r|\n/', ' ', strip_tags($reply->content)) }}\n';
                @endforeach
            @endif
            
            let prompt;
            
            if (isExpand) {
                const currentContent = $('#editor').html()
                    .replace(/<div>/g, '\n')
                    .replace(/<\/div>/g, '')
                    .replace(/<br>/g, '\n')
                    .replace(/&nbsp;/g, ' ');
                    
                prompt = `
                    Expand and improve the following response to a support ticket:
                    
                    Current draft:
                    ${currentContent}
                    
                    This is for a ticket with the following details:
                    Recipient: ${recipientName}
                    Category: ${ticketCategory}
                    Subject: ${ticketSubject}
                    
                    Original Message:
                    ${ticketContent}
                    
                    ${previousConversation ? `Previous messages:\n${previousConversation}` : ''}
                    
                    Expand this response to be more detailed and helpful while maintaining a professional tone. Keep addressing ${recipientName} by name. Don't make it too long to avoid TL;DR. Just make it direct and informative. 
                `;
            } else {
                prompt = `
                    Generate a helpful response to this ticket:
                    
                    Recipient: ${recipientName}
                    Category: ${ticketCategory}
                    Subject: ${ticketSubject}
                    
                    Original Message:
                    ${ticketContent}
                    
                    ${previousConversation ? `Previous messages:\n${previousConversation}` : ''}
                    
                    Write a professional, friendly response. Address ${recipientName} by name. Be helpful, concise, and solution-focused.
                `;
            }
            
            try {
                const aiResponse = await getAIResponse(prompt);
                
                $('#editor').html(aiResponse.replace(/\n/g, '<br>'));
                
                $('#aiLoadingIndicator').addClass('hidden');
                updateAIButton();
                $(this).removeClass('opacity-50 cursor-not-allowed').prop('disabled', false);
            } catch (error) {
                console.error("Error getting AI response:", error);
                $('#aiLoadingIndicator').addClass('hidden');
                updateAIButton();
                $(this).removeClass('opacity-50 cursor-not-allowed').prop('disabled', false);
                alert("Sorry, I couldn't generate a suggestion at this time. Please try again later.");
            }
        });
        
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
            } catch (error) {
                console.error("Error calling AI API:", error.response ? error.response.data : error.message);
                return "I'm having trouble connecting to my brain right now. Please try again later or contact support.🤖";
            }
        }
    });
</script>
