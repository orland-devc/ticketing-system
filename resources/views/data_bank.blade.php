<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PSU ChatBot Data Bank</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="icon" href="{{ asset('images/botbot.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .stop-scroll {
            overflow: hidden;
        }
        body {
            font-family: Poppins, 'Figtree', sans-serif;
            background: rgb(238,174,202);
            background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
            /* background-color: #f0f4f8; */
        }
        .chat-container {
            background-color: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .chat-header {
            padding: 20px;
            color: #ffffff;
            text-align: center;
        }
        .data-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }
        .data-table th, .data-table td {
            border: none;
            padding: 12px 16px;
            text-align: left;
        }
        .data-table thead {
            background-color: #f8fafc;
        }
        .data-table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #64748b;
        }
        .data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .data-table tbody tr:hover {
            background-color: #e2e8f0;
        }
        .form-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        .btn {
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
            transition: all 0.15s ease-in-out;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .btn-secondary {
            background-color: #64748b;
            color: #ffffff;
        }
        .btn-secondary:hover {
            background-color: #475569;
        }
        .modal-content {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        /* .modal-content.show {
            opacity: 1;
            transform: scale(1);
        } */
        .modal {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }
        /* .modal.show {
            opacity: 1;
        } */
        .animated-pulse {
            animation: pulse 0.2s ease-in-out;
        }
        .animated-vanish {
            animation: vanish 0.2s ease-in-out;
        }
        .animated-close {
            animation: close 0.2s ease-in-out;
        }
        @keyframes pulse {
            0% {
                opacity: 0;
                scale: 0.9;
            }
            50% {
                scale: 1.05;
            }
            100% {
                opacity: 1;
                scale: 1;
            }
        }
        @keyframes vanish {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
        @keyframes close {
            0% {
                scale: 1;
                opacity: 1;
            }
            50% {
                scale: 1.05;
                opacity: 1;
            }
            100% {
                scale: 0.9;
                opacity: 0;
            }
        }
        .drop-shadow {
            filter: drop-shadow(10px 10px 10px yellow); /* Adjust values for shadow */
        }

    </style>
</head>
<body id="body" class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="chat-container">
            <div class="chat-header bg-gray-800">
                <img src="{{ asset('images/bot.png') }}" id="botImage" class="mx-auto h-24 w-auto mb-4 drop-shadow" alt="Bot Image">
                <h1 class="text-3xl font-bold">
                    @if ( isset($botName->message) )
                        {{ $botName->message }}
                    @else 
                        Unnamed
                    @endif Data Bank</h1>
                <p class="text-sm mt-2 opacity-75">Powered by Pangasinan State University</p>
            </div>
            
            <div class="p-6">
                <div class="flex justify-end mb-6">
                    <x-primary-button onclick="openAdd()" class="btn btn-primary flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add New Entry
                    </x-primary-button>
                </div>
                
                @if ($dataBanks->isEmpty())
                    <p class="text-center text-gray-500 py-8">No records found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="w-1/4">Chat Pattern</th>
                                    <th class="w-1/2">Chat Response</th>
                                    <th>Author</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataBanks as $dataBank)
                                    <tr class="clickable-row cursor-pointer" onclick="openEdit('{{ $dataBank->id }}', '{{ addslashes($dataBank->chatPattern) }}', '{{ addslashes($dataBank->chatResponse) }}')">
                                        <td>{{ $dataBank->chatPattern }}</td>
                                        <td>{{ Str::limit($dataBank->chatResponse, 70) }}</td>
                                        <td>
                                            {{ $dataBank->author->name }}
                                            @if ($dataBank->created_at != $dataBank->updated_at)
                                                <span class="text-xs text-gray-400 ml-1">(edited)</span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <button class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="modal" class="modal fixed inset-0 hidden items-center justify-center z-50">
        <div id="modal-content" class="modal-content w-1/2 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 id="modalTitle" class="text-2xl font-bold">Add New Entry</h2>
                <a href="#" class="rounded-full">
                    <ion-icon name="alert-circle" class="text-3xl text-gray-500 hover:text-gray-800"></ion-icon>
                </a>
            </div>
            <form id="dataForm" action="{{ route('data_bank.store') }}" method="POST">
                @csrf
                <input type="hidden" id="updateId" name="id" value="">
                <div class="mb-4">
                    <label for="chatPattern" class="block text-md font-medium text-gray-700 mb-1">Chat Pattern</label>
                    <input type="text" id="chatPattern" name="chatPattern" required class="form-input text-md" placeholder="Enter chat pattern">
                </div>
                <div class="mb-4">
                    <label for="chatResponse" class="block text-md font-medium text-gray-700 mb-1">Chat Response</label>
                    <textarea id="chatResponse" name="chatResponse" rows="12" required class="form-input text-md" placeholder="Enter chat response"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <x-cancel-button type="button" onclick="closeModal()">Cancel</x-cancel-button>
                    <x-primary-button type="submit">Save</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAdd() {
            document.getElementById('modalTitle').textContent = 'Add New Entry';
            document.getElementById('dataForm').action = "{{ route('data_bank.store') }}";
            document.getElementById('updateId').value = '';
            document.getElementById('chatPattern').value = '';
            document.getElementById('chatResponse').value = '';
            openModal();
        }

        function openEdit(id, chatPattern, chatResponse) {
            document.getElementById('modalTitle').textContent = 'Edit Entry';
            document.getElementById('dataForm').action = "{{ route('dashboard.update', '') }}/" + id;
            document.getElementById('updateId').value = id;
            document.getElementById('chatPattern').value = chatPattern;
            document.getElementById('chatResponse').value = chatResponse;
            openModal();
        }

        function openModal() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            // document.getElementById('body').classList.add('stop-scroll');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Trigger reflow to ensure the transition works
            void modal.offsetWidth;
            
            modal.classList.add('show');
            modalContent.classList.add('animated-pulse');
            modalContent.classList.remove('animated-close');
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            document.getElementById('body').classList.remove('stop-scroll');
            
            modal.classList.add('animated-vanish');
            modalContent.classList.add('animated-close');
            modalContent.classList.remove('animated-pulse');
            // modalContent.classList.remove('show');

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.remove('animated-vanish')
                modalContent.classList.add('animated-close');
                modal.classList.add('hidden');
            }, 200); // Match this with the transition duration
        }

        // Close modal on escape key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>