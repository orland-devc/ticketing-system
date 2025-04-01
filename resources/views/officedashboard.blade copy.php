<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inbox Management System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Overall Statistics -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Overall Statistics</h3>
                            <div class="flex justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">Total Messages</p>
                                    <p class="text-2xl font-bold">{{ $totalMessages }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Open Tickets</p>
                                    <p class="text-2xl font-bold">{{ $openTickets }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Resolved Tickets</p>
                                    <p class="text-2xl font-bold">{{ $resolvedTickets }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Avg. Response Time</p>
                                    <p class="text-2xl font-bold">{{ $avgResponseTime }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Message Queue -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Message Queue</h3>
                            <ul>
                                @forelse ($messageQueue as $message)
                                    <li class="mb-2">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-sm text-gray-600">{{ $message->subject }}</p>
                                                <p class="text-xs text-gray-500">{{ $message->sender }}</p>
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</div>
                                        </div>
                                    </li>
                                @empty
                                    <p>No messages in the queue.</p>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Chatbot Analytics -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Chatbot Analytics</h3>
                            <div class="flex justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">Total Queries</p>
                                    <p class="text-2xl font-bold">{{ $totalQueries }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Resolved by Chatbot</p>
                                    <p class="text-2xl font-bold">{{ $queriesResolvedByChatbot }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Escalated Queries</p>
                                    <p class="text-2xl font-bold">{{ $escalatedQueries }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Top Query Category</p>
                                    <p class="text-2xl font-bold">{{ $topQueryCategory }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
                        <ul>
                            @forelse ($recentActivity as $activity)
                                <li class="mb-2">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-600">{{ $activity->description }}</p>
                                            <p class="text-xs text-gray-500">{{ $activity->user->name }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                                    </div>
                                </li>
                            @empty
                                <p>No recent activity.</p>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                            <a href="{{ route('tickets.create') }}" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-plus-circle fa-3x mb-2"></i>
                                <p class="text-sm font-semibold">Create Ticket</p>
                            </a>
                        </div>
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                            <a href="{{ route('messages.index') }}" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-envelope fa-3x mb-2"></i>
                                <p class="text-sm font-semibold">View Messages</p>
                            </a>
                        </div>
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                            <a href="{{ route('reports.index') }}" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-chart-bar fa-3x mb-2"></i>
                                <p class="text-sm font-semibold">Generate Report</p>
                            </a>
                        </div>
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                            <a href="{{ route('chatbot.settings') }}" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-robot fa-3x mb-2"></i>
                                <p class="text-sm font-semibold">Chatbot Settings</p>
                            </a>
                        </div>
                    </div>

                    <!-- User Management -->
                    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">User Management</h3>
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Role</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $user->name }}</td>
                                        <td class="border px-4 py-2">{{ $user->email }}</td>
                                        <td class="border px-4 py-2">{{ $user->role->name }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border px-4 py-2">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Knowledge Base Management -->
                    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Knowledge Base Management</h3>
                        <div class="mb-4">
                            <a href="{{ route('knowledgebase.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
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
                                            <a href="{{ route('knowledgebase.edit', $faq) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                            <form action="{{ route('knowledgebase.destroy', $faq) }}" method="POST" class="inline-block">
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
</x-app-layout>





@section('title', 'Admin Dashboard')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inbox Management System') }} &nbsp; <ion-icon name="analytics"></ion-icon>
        </h2>
    </x-slot>

    <div>
        <div class="max-w-screen sm:p-3 lg:p-5">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Overall Statistics -->
                        <a href="tickets"  class="bg-white shadow-md rounded-lg p-6 border hover:bg-gray-100" style="overflow-y: scroll; overflow: hidden;">
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Overall Statistics</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Tickets</p>
                                        <p class="text-2xl font-bold">{{$all_tickets}}</p>
                                        {{-- <p class="text-2xl font-bold">{{ $totalMessages }}</p> --}}
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Open Tickets</p>
                                        <p class="text-2xl font-bold">{{$open_tickets}}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Resolved Tickets</p>
                                        <p class="text-2xl font-bold">{{$closed_tickets}}</p>
                                        {{-- <p class="text-2xl font-bold">{{ $resolvedTickets }}</p> --}}
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Top Ticket Category</p>
                                        <p class="text-2xl font-bold">{{$top_category}}</p>
                                        {{-- <p class="text-2xl font-bold">{{ $avgResponseTime }}</p> --}}
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- Message Queue -->
                        <a href="tickets"  class="bg-white shadow-md rounded-lg p-6 border hover:bg-gray-100" style="overflow-y: scroll; overflow: hidden;">
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Message Queue</h3>
                                <ul>
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
                        <a href="manage-chatbot"  class="bg-white shadow-md rounded-lg p-6 border hover:bg-gray-100" style="overflow-y: scroll; overflow: hidden;">
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Chatbot Analytics</h3>
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Queries</p>
                                        {{-- <p class="text-2xl font-bold">{{ $totalQueries }}</p> --}}
                                        <p class="text-2xl font-bold">187</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Resolved by Chatbot</p>
                                        <p class="text-2xl font-bold">15 (82%)</p>
                                        {{-- <p class="text-2xl font-bold">{{ $queriesResolvedByChatbot }}</p> --}}
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Escalated Queries</p>
                                        <p class="text-2xl font-bold">17</p>
                                        {{-- <p class="text-2xl font-bold">{{ $escalatedQueries }}</p> --}}
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Top Query Category</p>
                                        <p class="text-2xl font-bold">0</p>
                                        {{-- <p class="text-2xl font-bold">{{ $topQueryCategory }}</p> --}}
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- Recent Activity -->
                        <div class="bg-white shadow-md rounded-lg p-6 border">
                            <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
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
                        <div class="bg-white shadow-md rounded-lg p-6 border">
                            <h3 class="text-lg font-semibold mb-4">User Management</h3>
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="px-4 py-2">Admin</th>
                                        <th class="px-4 py-2">Office Heads</th>
                                        {{-- <th class="px-4 py-2">Email</th> --}}
                                        <th class="px-4 py-2">Students</th>
                                        {{-- <th class="px-4 py-2">Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-2 text-center">{{ $admin_count }}</td>
                                        <td class="px-4 py-2 text-center">{{ $office_count }}</td>
                                        {{-- <td class="border px-4 py-2">{{ Auth::user()->email }}</td> --}}
                                        <td class="px-4 py-2 text-center">{{ $student_count }}</td>
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
                        </div>

                        <!-- Knowledge Base Management -->
                        <div class="bg-white shadow-md rounded-lg p-6 border">
                            <h3 class="text-lg font-semibold mb-4">Knowledge Base Management</h3>
                            <div class="mb-4">
                                <a href="manage-chatbot" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded uppercase">
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
                        <div class="mt-8 grid grid-cols-2 gap-6 uppercase">
                            <a href="admin-add-ticket" class="text-white">
                                <div class="bg-blue-800 hover:bg-blue-900 shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                                    <i class="fas fa-plus-circle fa-3x mb-2 my-auto"></i>
                                    <p class="text-sm font-semibold">Create Ticket</p>
                                </div>
                            </a>
                            <a href="" class="text-white">
                                <div class="bg-blue-800 hover:bg-blue-900 shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                                    <i class="fas fa-envelope fa-3x mb-2"></i>
                                    <p class="text-sm font-semibold">View Messages</p>
                                </div>
                            </a>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-6 uppercase">
                            <a href="tickets" class="text-white">
                                <div class="bg-blue-800 hover:bg-blue-900 shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                                    <i class="fas fa-ticket-alt fa-3x mb-2"></i>
                                    <p class="text-sm font-semibold">Manage Tickets</p>
                                </div>
                            </a>
                            <a href="manage-chatbot" class="text-white">
                                <div class="bg-blue-800 hover:bg-blue-900 shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                                    <i class="fas fa-robot fa-3x mb-2"></i>
                                    <p class="text-sm font-semibold">Chatbot Settings</p>
                                </div>
                            </a>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-6 uppercase">
                            <a href="/profile" class="text-white">
                                <div class="bg-blue-800 hover:bg-blue-900 shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                                    <i class="fas fa-user-shield fa-3x mb-2"></i>
                                    <p class="text-sm font-semibold">manage users</p>
                                </div>
                            </a>

                            <a href="/profile" class="text-white">
                                <div class="bg-blue-800 hover:bg-blue-900 shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                                    <i class="fas fa-chart-line fa-3x mb-2"></i>
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



@section('title', 'Admin Dashboard')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inbox Management System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Overall Statistics -->
                        <div class="bg-indigo-500 rounded-lg p-6 text-white">
                            <h3 class="text-lg font-semibold mb-4">Overall Statistics</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium">Total Tickets</p>
                                    <p class="text-2xl font-bold">{{ $all_tickets }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Open Tickets</p>
                                    <p class="text-2xl font-bold">{{ $open_tickets }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Resolved Tickets</p>
                                    <p class="text-2xl font-bold">{{ $closed_tickets }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Top Category</p>
                                    <p class="text-2xl font-bold">{{ $top_category }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Message Queue -->
                        <div class="bg-white rounded-lg p-6 shadow">
                            <h3 class="text-lg font-semibold mb-4">Message Queue</h3>
                            <ul>
                                @forelse ($ticket_list as $message)
                                    <li class="mb-2">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-sm font-medium">{{ $message->subject }}</p>
                                                <p class="text-xs text-gray-500">{{ $message->user->name }}</p>
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</div>
                                        </div>
                                    </li>
                                @empty
                                    <p>No messages in the queue.</p>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Chatbot Analytics -->
                        <div class="bg-white rounded-lg p-6 shadow">
                            <h3 class="text-lg font-semibold mb-4">Chatbot Analytics</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium">Total Queries</p>
                                    <p class="text-2xl font-bold">187</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Resolved by Chatbot</p>
                                    <p class="text-2xl font-bold">152 (82%)</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Escalated Queries</p>
                                    <p class="text-2xl font-bold">17</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Top Query Category</p>
                                    <p class="text-2xl font-bold">Admission</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white rounded-lg p-6 shadow">
                            <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
                            <ul>
                                <li class="mb-2">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm font-medium">Logged in</p>
                                            <p class="text-xs text-gray-500">{{ Auth::user()->name }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500">Just now</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">User Management</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white rounded-lg p-6 shadow">
                                <h4 class="text-sm font-medium mb-2">Admins</h4>
                                <p class="text-2xl font-bold text-center">{{ $admin_count }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-6 shadow">
                                <h4 class="text-sm font-medium mb-2">Office Heads</h4>
                                <p class="text-2xl font-bold text-center">{{ $office_count }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-6 shadow">
                                <h4 class="text-sm font-medium mb-2">Students</h4>
                                <p class="text-2xl font-bold text-center">{{ $student_count }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Knowledge Base Management</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white rounded-lg p-6 shadow">
                                <a href="{{ route('manage-chatbot.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Add FAQ
                                </a>
                            </div>
                            <div class="bg-white rounded-lg p-6 shadow overflow-y-auto max-h-48">
                                <ul>
                                    @forelse ($faqs as $faq)
                                        <li class="mb-2">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <p class="text-sm font-medium">{{ $faq->question }}</p>
                                                </div>
                                                <div class="flex items-center">
                                                    <a href="{{ route('manage-chatbot.edit', $faq) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('manage-chatbot.destroy', $faq) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
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

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <a href="{{ route('admin-add-ticket') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg p-6 flex flex-col items-center justify-center shadow">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="text-sm font-semibold uppercase">Create Ticket</span>
                        </a>
                        <a href="{{ route('tickets.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg p-6 flex flex-col items-center justify-center shadow">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            <span class="text-sm font-semibold uppercase">Manage Tickets</span>
                        </a>
                        <a href="{{ route('manage-chatbot.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg p-6 flex flex-col items-center justify-center shadow">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.104v5.714c0 .933.198 1.85.572 2.694H9.75M9.75 14.982h5.178A3.422 3.422 0 0018 17.646V21m-8.25-6.938h5.178A3.422 3.422 0 0118 17.646V21m0 0V6.409c0-1.091-.361-2.115-1-2.957l-1.029-1.388"></path>
                            </svg>
                            <span class="text-sm font-semibold uppercase">Chatbot Settings</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg p-6 flex flex-col items-center justify-center shadow">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-semibold uppercase">Manage Users</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



