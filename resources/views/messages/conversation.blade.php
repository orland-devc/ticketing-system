<div class="flex items-center text-2xl m-auto px-4 py-2" style="justify-content: space-between">
    <div class="flex items-center gap-3">
        <img src="{{ $contact->profile_picture }}" class="w-10 h-10 rounded-full" alt="">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 text-center">
                {{ $contact->name }}
            </h2>
            <p class="text-sm text-green-500 flex items-center"><ion-icon class="mr-2" name="ellipse"></ion-icon>Online</p>
        </div>
    </div>
    <a href="#" class="options">
        <ion-icon name="ellipsis-horizontal" style="margin-top: 4px;"></ion-icon>
    </a>
</div>
<hr class="border">

<div class="conversation-body overflow-y-auto flex-grow p-4">
    @foreach($messages as $message)
        <div class="mb-4 {{ $message->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">
            <div class="inline-block {{ $message->sender_id == Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg px-4 py-2 max-w-xs">
                {{ $message->content }}
            </div>
            <div class="text-xs text-gray-500 mt-1">
                {{ $message->created_at->format('h:i A') }}
            </div>
        </div>
    @endforeach
</div>

<div class="mb-0 p-4 pb-2 bg-white rounded-md flex-shrink-0">
    <form id="message-form" class="m-0 p-0">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $contact->id }}">
        <div class="flex items-center">
            <a href="#"><ion-icon name="duplicate" class="cursor-pointer text-4xl text-gray-600 hover:text-blue-700"></ion-icon></a>
            <textarea name="content" class="border-gray-300 appearance-none border rounded w-full py-2 mx-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" id="message-input" placeholder="Type a message..." autofocus></textarea>
            <button type="submit" class="cursor-pointer flex items-center bg-white hover:text-blue-700 text-blue-500 font-semibold ml-2 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <ion-icon class="text-4xl" name="send"></ion-icon>
            </button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#message-form').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = '{{ route("chat.send") }}';

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(response) {
                $('#message-input').val('');
                loadConversation({{ $contact->id }});
            }
        });
    });
});
</script>