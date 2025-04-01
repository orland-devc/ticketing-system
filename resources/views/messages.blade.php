@section('title', 'Messages')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }} &nbsp; <ion-icon name="chatbubbles"></ion-icon>
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-screen px-4">
            <div class="bg-white overflow-hidden pt-3">
                <div class="text-gray-900">
                    <div class="mb-4 flex space-x-4">
                        @foreach ([
                            'allMessages' => ['label' => 'All', 'count' => $allMessagesCount],
                            'unread' => ['label' => 'Unread', 'count' => $unreadMessagesCount],
                            'archived' => ['label' => 'Archived', 'count' => $archivedMessagesCount],
                        ] as $id => $data)
                            <a href="#" id="{{ $id }}" class="{{ $loop->first ? 'active' : 'inactive' }}">
                                {{ $data['label'] }}
                                @if ($data['count'] > 0)
                                    <span class="bg-{{ $id == 'unread' ? 'red-500' : 'gray-300' }} text-{{ $id == 'unread' ? 'white' : 'black' }} px-2 rounded-full ml-2">
                                        {{ $data['count'] }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                    <div class="overflow-x-auto">
                        <div class="bg-white shadow-md rounded-lg py-6 overflow-y-auto" style="max-height: 70vh;">
                            <table class="w-full">
                                @foreach ([
                                    'allbox' => $allMessages ?? collect(), 
                                    'unreadbox' => $unreadMessages ?? collect(), 
                                    'archivedbox' => $archivedMessages ?? collect()
                                ] as $boxId => $messageList)
                                    <tbody id="{{ $boxId }}" class="{{ $loop->first ? '' : 'hidden' }}">
                                        @forelse ($messageList as $message)
                                            <tr class="clickable-row hover:bg-gray-100 cursor-pointer" data-url="{{ route('message.show', ['message' => $message->id]) }}">
                                                @php
                                                    $partialContent = Str::limit($message->content, 80, ' . . .');
                                                @endphp
                                                <td class="py-4 px-5"><input type="checkbox"></td>
                                                <td class="px-1 font-bold">ID {{ $message->id }}</td>
                                                <td class="px-1 font-bold">{{ $message->sender->name }}</td>
                                                <td>{{ $message->subject }} — {{ $partialContent }}</td>
                                                <td class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="p-5 text-center">
                                                    <img src="{{ asset('images/no-messages.png') }}" width="420" alt="No messages" class="opacity-80 mx-auto mb-5">
                                                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                        No {{ $loop->parent->first ? 'unread' : 'messages' }} found.
                                                    </h2>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.mb-4 a');
        const boxes = {
            'allMessages': document.getElementById('allbox'),
            'unread': document.getElementById('unreadbox'),
            'archived': document.getElementById('archivedbox'),
        };

        tabs.forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                for (const [id, box] of Object.entries(boxes)) {
                    box.classList.toggle('hidden', id !== this.id);
                }
            });
        });

        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', () => {
                window.location = row.dataset.url;
            });
        });
    });
</script>
