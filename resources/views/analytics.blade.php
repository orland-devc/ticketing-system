<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Analytics Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="icon" href="{{ env('APP_LOGO') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-100">
    <div class="p-6 max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">System Analytics Dashboard</h1>
        
        <!-- Top Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- System Uptime -->
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-500">System Uptime <span class="font-normal text-gray-500 text-sm">(predefined)</span></h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900">99.9%</p>
                <p class="text-xs text-gray-500">Within this month ( {{ $currentMonth }} )</p>
            </div>

            <!-- Response Time -->
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-500">Avg Response Time</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900"> 
                    @if ($overallAvgResponseTime > 24)
                        {{ number_format($overallAvgResponseTime/24, 1) }} days
                    @else
                        {{ number_format($overallAvgResponseTime, 1) }} h
                    @endif    
                </p>
                <p class="text-xs text-gray-500">Within this month ( {{ $currentMonth }} )</p>
            </div>

            <!-- Active Users -->
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-500">Active Users <span class="font-normal text-gray-500 text-sm">(predefined)</span></h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900">1,234</p>
                <p class="text-xs text-gray-500">Currently online</p>
            </div>

            <!-- New Users -->
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-500">New Users</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 6l-9.5 9.5-5-5L1 18"></path>
                        <path d="M17 6h6v6"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900"> {{ $monthlyUsers }} </p>
                <p class="text-xs text-gray-500">Within this month ( {{ $currentMonth }} )</p>
            </div>
        </div>

        <!-- Middle Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Ticket Performance -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4"></path>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-800">Ticket Performance</h2>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Tickets</p>
                        <p class="text-xl font-bold text-gray-900"> {{ $total->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Resolved</p>
                        <p class="text-xl font-bold text-gray-900"> {{ $resolved->count() }} </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Avg Resolution Time</p>
                        <p class="text-xl font-bold text-gray-900"> {{ $resolution_time }} </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Satisfaction</p>
                        <p class="text-xl font-bold text-gray-900">4.8/5 <span class="font-normal text-gray-500 text-sm">(predefined)</span></p>
                    </div>
                </div>
            </div>

            <!-- Chatbot Performance -->
            {{-- <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-800">Chatbot Performance  <span class="font-normal text-gray-500 text-sm">(predefined)</span></h2>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Interactions</p>
                        <p class="text-xl font-bold text-gray-900">2,345</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Success Rate</p>
                        <p class="text-xl font-bold text-gray-900">92%</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Avg Response Time</p>
                        <p class="text-xl font-bold text-gray-900">1.2s</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">User Satisfaction</p>
                        <p class="text-xl font-bold text-gray-900">4.6/5</p>
                    </div>
                </div>
            </div> --}}

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center gap-2 mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-800">Often Returns Ticket</h2>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-2">Name</p>
                        <p class="text-xl font-bold text-gray-900"> {{ $userWithMostReturns }} </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-2">Tickets Returned</p>
                        <p class="text-xl font-bold text-gray-900"> {{ $totalReturns/2 }} </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Office Rankings Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Ticket Assignment Rankings -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Office Ticket Rankings</h2>
                <div class="space-y-4">
                    @foreach($officeStaffTickets as $key => $staff)
                    <div class="clickable flex items-center justify-between pb-2 border-b">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm font-semibold">{{ $key + 1 }}</span>
                            <span class="font-medium">{{ $staff->name }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-gray-900">{{ $staff->assigned_tickets_count }}</span>
                            <span class="text-sm text-gray-500 ml-1">tickets</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Response Time Rankings -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Response Time Rankings</h2>
                <div class="space-y-4">
                    @foreach($responseTimeRankings as $key => $staff)
                    <div class="clickable flex items-center justify-between pb-2 border-b">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 flex items-center justify-center bg-green-600 text-white rounded-full text-sm font-semibold">{{ $key + 1 }}</span>
                            <span class="font-medium">{{ $staff['name'] }}</span>
                        </div>
                        <div class="text-right">
                            @if($staff['avg_response_time'])
                            <span class="text-lg font-bold text-gray-900">
                                {{ $staff['avg_response_time'] >= 24 
                                    ? number_format($staff['avg_response_time'] / 24) . 'd' 
                                    : number_format($staff['avg_response_time'], 1) . 'h' 
                                }}
                            </span>                                <span class="text-sm text-gray-500 ml-1">avg</span>
                            @else
                                <span class="text-lg font-bold text-gray-900">N/A</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Weekly Ticket Volume</h2>
            <div class="h-64">
                <canvas id="ticketChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Initialize chart
        const ctx = document.getElementById('ticketChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Tickets',
                    data: [145, 132, 164, 123, 132, 90, 85],
                    backgroundColor: '#3b82f6',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

<style>
    .clickable {
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .clickable:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
</style>