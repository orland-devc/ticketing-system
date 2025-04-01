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
                <div class="w-full md:w-2/3 lg:w-1/2 bg-white rounded-lg p-6">
                    <div id="chat-container" style="height: 80vh;">
                        <div class="bida">
                            <center>
                                <img src="images/bot.png" class="botImage" alt="" id="botImage">
                                <div id="disappear">
                                    <h1 style="color: #37474f; user-select: none;">The First PSU ChatBot</h1>
                                    <p style="margin-top: -10px; color: #607d8b; user-select: none;">Made possible by one of a kind students in <br>Pangasinan State University San Carlos City Campus</p>
                                </div>
                            </center>
                        </div>
                        <div id="chat-messages" class="p-5" style="max-height: 70vh;"></div>
                    </div>
                    <input type="text" id="user-input" class="w-full mt-3" placeholder="Type your message..." autofocus>
                </div>
            </div>
        </div>
    </div>
</x-users-layout>

<script src="{{asset('js/queryProcessor.js')}}"></script>
 
<style>
    /* .user-message {
        background: yellow;
        padding: 0 20px;
    }
    .bot-message {
        background: blue;
    } */
    #chat-container {
        margin: 0 auto;
        padding: 20px 50px;
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
        transition: height 0.3 ease;
        height: 250px;
        pointer-events: none;
        user-select: none;
        margin-left: 5%;
        animation: botDown 0.3s ease-in-out;
    }
    
    /* Animation */
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
    </style>