@section('title', 'Messages')

@if (Auth::user()->role == "Administrator")
    <x-app-layout>
        @include('messages.content')
    </x-app-layout>
@elseif (Auth::user()->role == "Student")
    <x-users-layout>
        @include('messages.content')
    </x-users-layout>
@elseif (Auth::user()->role == "Office")
    <x-office-layout>
        @include('messages.content')
    </x-office-layout>
@endif


<style>
    .animated-rotate-back {
        animation: rotate-back 0.2s ease-in-out;
    }
    .animated-rotate {
        animation: rotate 0.2s ease-in-out;
    }
    @keyframes rotate {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(90deg);
        }
    }
    @keyframes rotate-back {
        0% {
            transform: rotate(90deg);
        }
        100% {
            transform: rotate(0deg);
        }
    }

    .attachment-image {
        width: 300px;
        max-width: 400px;
        object-fit: cover;
        cursor: pointer;
    }

    .message {
        max-width: 70%;
        width: fit-content;
        border-radius: 18px;
        position: relative;
        animation: fadeIn 0.3s ease-out;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .user-message {
        background-color: #667eea;
        color: white;
        border-bottom-right-radius: 4px;
        margin-left: auto;
    }

    .bot-message {
        background-color: #f0f0f0;
        color: #333;
        border-bottom-left-radius: 4px;
        margin-right: auto;
    }

    .bot-message:hover {
        background-color: #e2e2e2;
    }

    /* .chat-box {
        background: linear-gradient(135deg, #f0f4ff, #ffffff);
    } */
 
    .send-button {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background-color: #667eea;
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .send-button:hover {
        background-color: #3b5ae6;
        transform: translateY(-50%) scale(1.05);
    }

    #chatList {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }

    #chatList::-webkit-scrollbar {
        width: 6px;
    }

    #chatList::-webkit-scrollbar-track {
        background: #f7fafc;
    }

    #chatList::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 3px;
    }

    .scrollable-container {
        overflow-y: auto;
        height: calc(95% - 90px - 30px); /* adjust the height to exclude the contact info section */
    }
    
    .scrollable-container::-webkit-scrollbar {
        width: 6px;
    }
    .scrollable-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .scrollable-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    .scrollable-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    #showWhenActive::-webkit-scrollbar {
        width: 6px;
    }
    #showWhenActive::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    #showWhenActive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    #showWhenActive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    #contactInfo {
        border-bottom: 1px solid #e2e8f0;
    }

</style>