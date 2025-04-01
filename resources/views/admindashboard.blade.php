@section('title', 'Admin Dashboard')

<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-semibold text-xl text-gray-800 leading-tight select-none">
            {{-- <img src="{{ asset('images/system logo.png') }}" class="w-6 h-6 mr-3 rounded-full" alt=""> --}}
            {{ __('Welcome, Admin ') }} 
            {{ Auth::user()->name }}
            {{-- {{ __('Inbox Management System') }} &nbsp;  --}}
        </h2>
    </x-slot>
    
    <style>
        .choices {
            border-radius: 15px;
            padding: 20px;
            transition: all 0.1s ease;
            cursor: pointer;
            background: #fff;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.15);
            transition: box-shadow 0.3s ease;
        }
        .choices:hover {
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.15);
        }
    </style>

    <div class=" select-none">
        <div class="max-w-screen p-4">
            <div class="sm:rounded-lg">
                <div class="text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                        <!-- Overall Statistics -->
                        <a href="tickets"  class="choices" style="">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Tickets</h3>
                                    <ion-icon name="ticket" class="text-3xl text-indigo-600"></ion-icon>
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
                                        @if (isset($top_count) && isset($top_category))
                                            <p class="text-sm text-gray-600">Top Ticket Category (<b>{{$top_count}}</b>)</p>
                                            <p class="text-xl font-bold">{{$top_category}}</p>
                                        @endif

                                        {{-- <p class="text-2xl font-bold">{{ $avgResponseTime }}</p> --}}
                                    </div>
                                </div>
                        </a>

                        <!-- Message Queue -->
                        {{-- <a href="tickets"  class="choices">
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
                                </ul>
                            </div>
                        </a> --}}

                        <!-- Chatbot Analytics -->
                        <a href="manage-chatbot"  class="choices">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Chatbot</h3>
                                    <ion-icon name="logo-octocat" class="text-3xl text-indigo-600"></ion-icon>

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
                        {{-- <div class="choices">
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
                        </div> --}}

                        <!-- User Management -->
                        <a href="UserManagement" class="choices">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">User Management</h3>
                                <ion-icon name="people" class="text-3xl text-indigo-600"></ion-icon>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-600">Administrator</p>
                                    {{-- <p class="text-2xl font-bold">{{ $totalQueries }}</p> --}}
                                    <p class="text-xl font-bold">{{ $admin_count }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Office Heads</p>
                                    <p class="text-xl font-bold">{{ $office_count }}</p>
                                    {{-- <p class="text-2xl font-bold">{{ $queriesResolvedByChatbot }}</p> --}}
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Students</p>
                                    <p class="text-xl font-bold">{{ $student_count }}</p>
                                    {{-- <p class="text-2xl font-bold">{{ $escalatedQueries }}</p> --}}
                                </div>
                            </div>
                            {{-- <table class="w-full table-auto">
                                <thead>
                                    <tr class="border-none">
                                        <th class="px-4 py-2 bg-teal-300 border-none" style="border-radius: 10px 0 0 0">Admin</th>
                                        <th class="px-4 py-2 bg-teal-300 border-none">Office Heads</th>
                                        <th class="px-4 py-2 bg-teal-300 border-none" style="border-radius: 0 10px 0 0">Students</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-2 text-center bg-gray-200 border-none" style="border-radius: 0 0 0 10px">{{ $admin_count }}</td>
                                        <td class="px-4 py-2 text-center bg-gray-200 border-none">{{ $office_count }}</td>
                                        <td class="border px-4 py-2">{{ Auth::user()->email }}</td>
                                        <td class="px-4 py-2 text-center bg-gray-200 border-none" style="border-radius: 0 0 10px 0">{{ $student_count }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('profile.edit',) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form action="" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> --}}
                        </a>

                        <!-- Knowledge Base Management -->
                        {{-- <div class="choices">
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
                        </div> --}}

                    </div>

                    <div class="flex grid gap-4 mb-8 md:grid-cols-1 lg:grid-cols-2">
                        <div class="choices">
                            <h3 class="text-xl font-bold mb-4">User and Ticket Growth</h3>
                            <div class="h-72 relative">
                                <canvas id="userGrowthChart"></canvas>
                            </div>
                        </div>
                        <div class="choices">
                            <h3 class="text-xl font-bold mb-4">Most Ticket Categories</h3>
                            <div class="h-72 relative">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                        
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

                    <div class="grid grid-cols-1 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-5 gap-6 uppercase">
                        <a href="admin-add-ticket" class="text-white">
                            <div class="quick-actions">
                                <i class="fas fa-plus-circle fa-2x mb-2 my-auto"></i>
                                <p class="text-sm font-semibold">Create Ticket</p>
                            </div>
                        </a>
                        <a href="messages" class="text-white">
                            <div class="quick-actions">
                                <i class="fas fa-envelope fa-2x mb-2"></i>
                                <p class="text-sm font-semibold">View Messages</p>
                            </div>
                        </a>
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
                        <a href="/UserManagement" class="text-white">
                            <div class="quick-actions">
                                <i class="fas fa-user-shield fa-2x mb-2"></i>
                                <p class="text-sm font-semibold">manage users</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User Growth and Ticket Submission Chart
            const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(userGrowthCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthLabels),
                    datasets: [
                        {
                            label: 'New Users',
                            data: @json($monthDataUser),
                            backgroundColor: '#4552e3',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Tickets Submitted',
                            data: @json($monthDataTickets),
                            backgroundColor: '#FDB725',
                            borderWidth: 1,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
    
            // JS line chart for ticket categories submitted for the past 4 months
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'line',
                data: {
                    labels: @json($monthLabels),
                    datasets: @json($categoryDatasets) // Use the structured category datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hides the legend (labels above the chart)
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            },
                        }
                    }
                }
            });
        });
    </script>
    
    
    
</x-app-layout>