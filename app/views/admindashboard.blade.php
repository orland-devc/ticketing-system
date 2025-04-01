@section('title', 'Admin Dashboard')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inbox Management System') }} &nbsp; <ion-icon name="analytics"></ion-icon>
        </h2>
    </x-slot>
    
    <style>
        .choices {
            border-radius: 15px;
            border: 2px solid #ddd;
            padding: 20px;
            transition: all 0.1s ease;
            cursor: pointer;
        }
        .choices:hover {
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.15);
        }
    </style>

    <div>
        <div class="max-w-screen sm:p-3 lg:p-5">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Overall Statistics -->
                        <a href="tickets"  class="choices" style="">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Overall Statistics</h3>
                                    <i class="fas fa-chart-line text-3xl text-blue-500"></i>
                                </div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Tickets</p>
                                        <p class="text-xl font-bold">{{$all_tickets}}</p>
                                        {{-- <p class="text-2xl font-bold">{{ $totalMessages }}</p> --}}
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Open Tickets</p>
                                        <p class="text-xl font-bold">{{$open_tickets}}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Resolved Tickets</p>
                                        <p class="text-xl font-bold">{{$closed_tickets}}</p>
                                        {{-- <p class="text-2xl font-bold">{{ $resolvedTickets }}</p> --}}
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Top Ticket Category</p>
                                        <p class="text-xl font-bold">{{$top_category}}</p>
                                        {{-- <p class="text-2xl font-bold">{{ $avgResponseTime }}</p> --}}
                                    </div>
                                </div>
                        </a>

                        <!-- Message Queue -->
                        <a href="tickets"  class="choices">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Message Queue</h3>
                                    <i class="fas fa-envelope-open-text text-3xl text-teal-500"></i>
                                </div>                                <ul>
                                    @forelse ($ticket_list as $message)
                                        <li class="mb-2">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <p class="text-sm text-gray-600 font-semibold">{{ $message->subject }}</p>
                                                    <p class="text-xs text-gray-500">{{ $message->user->name }}</p>
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</div>
                                            </div>
                                        </li>
                                    @empty
                                        <p>No messages in the queue.</p>
                                    @endforelse
                                    {{-- <li class="mb-2">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-sm text-gray-600">Scholarships</p>
                                                <p class="text-xs text-gray-500">Orland Benniedict D. Sayson</p>
                                            </div>
                                            <div class="text-xs text-gray-500">Just Now</div>
                                        </div>
                                    </li>

                                    <li class="mb-2">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-sm text-gray-600">Admission</p>
                                                <p class="text-xs text-gray-500">Levi D. Marbella</p>
                                            </div>
                                            <div class="text-xs text-gray-500">April 19, 2024</div>
                                        </div>
                                    </li> --}}
                                </ul>
                            </div>
                        </a>

                        <!-- Chatbot Analytics -->
                        <a href="manage-chatbot"  class="choices">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Chatbot Analytics</h3>
                                    <i class="fas fa-robot text-3xl text-green-500"></i>
                                </div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Queries</p>
                                        {{-- <p class="text-2xl font-bold">{{ $totalQueries }}</p> --}}
                                        <p class="text-xl font-bold">187</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Resolved by Chatbot</p>
                                        <p class="text-xl font-bold">15 (82%)</p>
                                        {{-- <p class="text-2xl font-bold">{{ $queriesResolvedByChatbot }}</p> --}}
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Escalated Queries</p>
                                        <p class="text-xl font-bold">17</p>
                                        {{-- <p class="text-2xl font-bold">{{ $escalatedQueries }}</p> --}}
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Top Query Category</p>
                                        <p class="text-xl font-bold">0</p>
                                        {{-- <p class="text-2xl font-bold">{{ $topQueryCategory }}</p> --}}
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- Recent Activity -->
                        <div class="choices">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                                <i class="fas fa-history text-3xl text-pink-500"></i>
                            </div>
                            <ul>
                                <li class="mb-2">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-600">Logged in</p>
                                            <p class="text-xs text-gray-500">{{ Auth::user()->name }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500">Just now</div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- User Management -->
                        <a href="UserManagement" class="choices">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">User Management</h3>
                                <i class="fas fa-users-cog text-3xl text-teal-500"></i>
                            </div>
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="border-none">
                                        <th class="px-4 py-2 bg-teal-300 border-none" style="border-radius: 10px 0 0 0">Admin</th>
                                        <th class="px-4 py-2 bg-teal-300 border-none">Office Heads</th>
                                        {{-- <th class="px-4 py-2">Email</th> --}}
                                        <th class="px-4 py-2 bg-teal-300 border-none" style="border-radius: 0 10px 0 0">Students</th>
                                        {{-- <th class="px-4 py-2">Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-2 text-center bg-gray-200 border-none" style="border-radius: 0 0 0 10px">{{ $admin_count }}</td>
                                        <td class="px-4 py-2 text-center bg-gray-200 border-none">{{ $office_count }}</td>
                                        {{-- <td class="border px-4 py-2">{{ Auth::user()->email }}</td> --}}
                                        <td class="px-4 py-2 text-center bg-gray-200 border-none" style="border-radius: 0 0 10px 0">{{ $student_count }}</td>
                                        {{-- <td class="px-4 py-2">
                                            <a href="{{ route('profile.edit',) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form action="" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                </tbody>
                            </table>
                        </a>

                        <!-- Knowledge Base Management -->
                        <div class="choices">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Knowledge Base Management</h3>
                                <i class="fas fa-book-open text-3xl text-orange-500"></i>
                            </div>
                            <div class="mb-4">
                                <a href="manage-chatbot" class="bg-orange-800 hover:bg-orange-900 text-white font-bold py-2 px-4 rounded uppercase">
                                    Add FAQ
                                </a>
                            </div>
                            <ul>
                                @forelse ($faqs as $faq)
                                <li class="mb-2">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-600">{{ $faq->question }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <a href="{{ route('manage-chatbot.edit', $faq) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                            <form action="{{ route('manage-chatbot.destroy', $faq) }}" method="POST" class="inline-block">
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

                        <!-- Quick Actions -->
                        <style>
                            .quick-actions {
                                background-color: #1e40af; /* bg-blue-800 */
                                transition: background-color 0.2s ease; /* hover:bg-blue-900 */
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08); /* shadow-md */
                                border-radius: 1rem; /* rounded-lg */
                                padding: 1.5rem; /* p-6 */
                                display: flex; /* flex */
                                flex-direction: column; /* flex-col */
                                justify-content: center; /* justify-center */
                                align-items: center; /* items-center */
                            }

                            .quick-actions:hover {
                                background-color: #2b55c8; /* hover:bg-blue-900 */
                            }
                        </style>
                        <div class="mt-8 grid grid-cols-2 gap-6 uppercase">
                            <a href="admin-add-ticket" class="text-white">
                                <div class="quick-actions">
                                    <i class="fas fa-plus-circle fa-2x mb-2 my-auto"></i>
                                    <p class="text-sm font-semibold">Create Ticket</p>
                                </div>
                            </a>
                            <a href="" class="text-white">
                                <div class="quick-actions">
                                    <i class="fas fa-envelope fa-2x mb-2"></i>
                                    <p class="text-sm font-semibold">View Messages</p>
                                </div>
                            </a>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-6 uppercase">
                            <a href="tickets" class="text-white">
                                <div class="quick-actions">
                                    <i class="fas fa-ticket-alt fa-2x mb-2"></i>
                                    <p class="text-sm font-semibold">Manage Tickets</p>
                                </div>
                            </a>
                            <a href="manage-chatbot" class="text-white">
                                <div class="quick-actions">
                                    <i class="fas fa-robot fa-2x mb-2"></i>
                                    <p class="text-sm font-semibold">Chatbot Settings</p>
                                </div>
                            </a>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-6 uppercase">
                            <a href="/UserManagement" class="text-white">
                                <div class="quick-actions">
                                    <i class="fas fa-user-shield fa-2x mb-2"></i>
                                    <p class="text-sm font-semibold">manage users</p>
                                </div>
                            </a>

                            <a href="/profile" class="text-white">
                                <div class="quick-actions">
                                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                                    <p class="text-sm font-semibold">View Analytics</p>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>