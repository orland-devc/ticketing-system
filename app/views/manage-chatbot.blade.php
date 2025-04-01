@section('title', 'Chatbot Management')
<x-app-layout>
    <x-slot name="header" class="bg-yellow-900">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Chatbot') }} <ion-icon name="logo-reddit"></ion-icon>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Chatbot Configuration -->
                        <div class="bg-white shadow-md rounded-lg p-6 border">
                            <h3 class="text-lg font-semibold mb-4">Chatbot Configurations</h3>
                            <form action="" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700 font-bold mb-2">Chatbot Name:</label>
                                    <input type="text" id="name" name="name" value="PSU Chatbot" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                                <div class="mb-4">
                                    <label for="greeting" class="block text-gray-700 font-bold mb-2">Greeting Message:</label>
                                    <textarea id="greeting" name="greeting" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>What's on your mind?</textarea>
                                </div>
                                <x-primary-button type="submit">Save Changess</x-primary-button>
                            </form>
                        </div>

                        <!-- Chatbot Analytics -->
                        <div class="bg-white shadow-md rounded-lg p-6 border">
                            <h3 class="text-lg font-semibold mb-4">Chatbot Analytics</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-600">Total Queries</p>
                                    <p class="text-2xl font-bold">24</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Resolved by Chatbot</p>
                                    <p class="text-2xl font-bold">3</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Escalated Queries</p>
                                    <p class="text-2xl font-bold">6</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Top Query Category</p>
                                    <p class="text-2xl font-bold">Admission</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Knowledge Base Management -->
                    <div class="mt-8 bg-white shadow-md rounded-lg p-6 border">
                        <h3 class="text-lg font-semibold mb-4">Knowledge Base Management</h3>
                        <div class="mb-4">
                            <a href="#" onclick="toggleAddFAQ()" class="primary_button">
                                Add FAQ
                            </a>
                        </div>
                        <ul>
                            @forelse ($faqs as $faq)
                                <li class="mb-2 bg-gray-100 rounded-lg p-4 border">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="text-lg font-semibold">{{ $faq->question }}</h4>
                                            <p class="text-gray-700">{{ $faq->answer }}</p>
                                        </div>
                                        <div class="text-md text-gray-500">
                                            <a href="#" onclick="toggleEditFAQ({{ json_encode($faq) }})" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                            <form action="{{ route('manage-chatbot.destroy', $faq->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <p>No FAQs found.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add FAQs -->
    <div id="addFAQ" class="max-h-screen max-w-7xl mx-auto sm:px-6 lg:px-8 text-xl overflow-hidden hidden" style="animation: openAss 0.2s ease-in-out; z-index: 999;">
        <div class="bg-white overflow-hidden" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #0009; backdrop-filter: blur(5px);">
            <div class="flex items-center justify-center h-full"> <!-- Added flex and justify-center classes -->
                <div class="w-full sm:max-w-lg mt-2 px-10 py-8 bg-white shadow-md sm:rounded-lg" style="margin-top: -90px">
                    <h3 class="text-2xl text-gray-700 font-semibold mb-4">Add FAQ for Chatbot</h3>
                    <div><br>
    
                        <form method="POST" action="{{ route('manage-chatbot.store') }}">
                            @csrf
    
                            <div class="mb-4">
                                <label for="question" class="block text-gray-700 font-semibold mb-2">Question</label>
                                <input type="text" name="question" id="question" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
    
                            <div class="mb-6">
                                <label for="answer" class="block text-gray-700 font-semibold mb-2">Answer</label>
                                <textarea name="answer" id="answer" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                            </div>
    
                            <div class="grid grid-cols-2 gap-6">
                                <button onclick="hideAddFaq()" class="items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                    Cancel
                                </button>
                                <button type="submit" class="items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                    Add FAQ
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit FAQs -->
    <div id="editFAQ" class="max-h-screen max-w-7xl mx-auto sm:px-6 lg:px-8 text-xl overflow-hidden hidden" style="animation: openAss 0.2s ease-in-out; z-index: 999;">
        <div class="bg-white overflow-hidden" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #0009; backdrop-filter: blur(5px);">
            <div class="flex items-center justify-center h-full"> <!-- Added flex and justify-center classes -->
                <div class="w-full sm:max-w-lg mt-2 px-10 py-8 bg-white shadow-md sm:rounded-lg" style="margin-top: -90px">
                    <h3 class="text-2xl text-gray-700 font-semibold mb-4">Update this FAQ</h3>
                    <div><br>
    
                        <form method="POST" action="{{ route('manage-chatbot.update', $faq) }}">
                            @csrf
                            @method('PUT')
    
                            <div class="mb-4">
                                <label for="question" class="block text-gray-700 font-semibold mb-2">Question</label>
                                <input type="text" name="question" id="question" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $faq->question }}" required>
                            </div>
    
                            <div class="mb-6">
                                <label for="answer" class="block text-gray-700 font-semibold mb-2">Answer</label>
                                <textarea name="answer" id="answer" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $faq->answer }}</textarea>
                            </div>
    
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <a href="#" onclick="hideEditFaq()" class="items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                    Cancel
                                </a>
                                <button type="submit" class="items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                    update faq
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' || event.keyCode === 27) {
                hideAddFaq();
                hideEditFaq();
            }
        });

        function toggleAddFAQ() {
            const addFAQ = document.getElementById('addFAQ');
    
            addFAQ.classList.remove("hidden");
        }
    
        function hideAddFaq() {
            const addFAQ = document.getElementById('addFAQ');
            
            addFAQ.classList.add( "hidden" );
    
        }
    
        function toggleEditFAQ(faq) {
            const editFAQ = document.getElementById('editFAQ');
            const questionInput = editFAQ.querySelector('#question');
            const answerInput = editFAQ.querySelector('#answer');

            questionInput.value = faq.question;
            answerInput.value = faq.answer;

            editFAQ.classList.remove("hidden");
        }
    
        function hideEditFaq() {
            const editFAQ = document.getElementById('editFAQ');
            
            editFAQ.classList.add( "hidden" );
    
        }

        // function hideEditFaq() {
        //     const editFAQ = document.getElementById('editFAQ');
        //     const editForm = document.getElementById('editForm');
        //     editFAQ.classList.add('animated-vanish');
        //     editForm.classList.add('animated-close');

        //     setTimeout(() => {
        //         editFAQ.style.display = 'none';
        //         editFAQ.classList.remove('animated-pulse');
        //         editForm.classList.remove('animated-close');
        //         editFAQ.classList.remove('animated-vanish');
        //     }, 300);

        // }

        </script>

</x-app-layout>