@section('title', 'Chatbot Management')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Chatbot') }}
            <span class="inline-block ml-2">
                <ion-icon name="logo-octocat" class="w-6 h-6"></ion-icon>
            </span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('dashboard.updateAll') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-10">
                            <div class="flex items-center justify-center">
                                <div class="relative group">
                                    <img id="profile-pic-preview" 
                                    @if (isset($botProfile->message))
                                        src="{{ asset($botProfile->message) }}"
                                    @else
                                        src="{{ asset('images/PSU logo.png') }}"
                                    @endif  alt="Profile Picture" class="w-40 h-40 rounded-full object-cover border-4 border-indigo-200 shadow-lg transition-all duration-300 group-hover:border-indigo-400">
                                    
                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <label for="profile-picture" class="cursor-pointer p-4">
                                            <ion-icon name="camera" class="w-8 h-8"></ion-icon>
                                            <input type="file" id="profile-picture" name="profile_picture" class="hidden" onchange="previewProfilePicture(event)">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Chatbot Name</label>
                                    <input type="text" id="name" name="name" value="{{ $botName->message ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Name your chatbot" autocomplete="off">
                                </div>

                                <div>
                                    <label for="greeting" class="block text-sm font-medium text-gray-700 mb-1">Greeting Message</label>
                                    <input type="text" id="greeting" name="greeting" value="{{ $botGreeting->message ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Greeting Message" autocomplete="off">
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="fallback" class="block text-sm font-medium text-gray-700 mb-1">Fallback Message</label>
                                    <input type="text" id="fallback" name="fallback" value="{{ $botFallback->message ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Fallback Message" autocomplete="off">
                                </div>

                                <div>
                                    <label for="repeat" class="block text-sm font-medium text-gray-700 mb-1">Response on Repeat</label>
                                    <input type="text" id="repeat" name="repeat" value="{{ $botRepeated->message ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Response on Repeat" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end">
                            <x-primary-button>
                                <ion-icon name="save-outline" class="w-5 h-5 mr-2"></ion-icon>
                                Save
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Knowledge Base Management</h3>
                        <a href="data_bank" class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition-colors duration-300">
                            <ion-icon name="library-outline" class="w-5 h-5 mr-2"></ion-icon>
                            Go to Chatbot Data Bank
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewProfilePicture(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profile-pic-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>