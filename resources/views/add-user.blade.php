@section('title', 'User Management')

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Management') }}
                <ion-icon name="people" class="ml-2 text-2xl"></ion-icon>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 max-md:py-0">

        <a onclick="addUserTab()" class="text-white text-2xl fixed h-20 w-20 bottom-10 right-10 bg-gray-900 hover:bg-gray-800 hover:scale-105 active:scale-110 transition-all rounded-full flex items-center justify-center cursor-pointer ">
            <i class="fas fa-user-plus"></i>
        </a>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-6 flex justify-between items-center flex-wrap">
                            <div class="flex space-x-4 select-none">
                                <div class="user-tab-container">
                                    <div class="user-tab-slider"></div>
                                    @foreach ([
                                        'allUsers' => ['label' => 'All', 'count' => $usersCount, 'icon' => 'people'],
                                        'admins' => ['label' => 'Administrators', 'count' => $adminCount, 'icon' => 'shield'],
                                        'office' => ['label' => 'Office', 'count' => $officeCount, 'icon' => 'briefcase'],
                                        'students' => ['label' => 'Students', 'count' => $studentCount, 'icon' => 'book'],
                                        'alumni' => ['label' => 'Alumni', 'count' => $alumniCount, 'icon' => 'school']
                                    ] as $id => $data)
                                        <a href="#" id="{{ $id }}" class="user-tab {{ $id === 'allUsers' ? 'active' : 'inactive' }} flex items-center">
                                            <ion-icon name="{{ $data['icon'] }}" class="mr-2"></ion-icon>
                                            <span class="md:block hidden max-md:hidden">{{ $data['label'] }}</span>
                                            @if ($data['count'] > 0)
                                                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full ml-2">
                                                    {{ $data['count'] }}
                                                </span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="mt-4 sm:mt-0">
                                    <input type="text" id="user-search" placeholder="Search users..." class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 ease-in-out">
                                </div>
                                <div class="mt-4 sm:mt-0">
                                    {{-- <a href="" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors duration-300 flex items-center">
                                        <ion-icon name="add" class="mr-2"></ion-icon>
                                        Add User
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto select-none">
                            <div class="bg-white overflow-y-auto overflow-x-hidden table-data" style="height: 70vh;">
                                @foreach ([
                                    'allUsersbox' => $users, 
                                    'adminsbox' => $admins, 
                                    'officebox' => $offices, 
                                    'studentsbox' => $students, 
                                    'alumnibox' => $alumni
                                ] as $boxId => $userList)
                                    <div class="user-content {{ $boxId === 'allUsersbox' ? '' : 'hidden' }}" id="{{ $boxId }}">
                                        @forelse ($userList as $user)                             
                                            <a href="{{ route('users.edit', ['user' => $user->id]) }}" 
                                                class="clickable border-l-8 border-t 
                                            @if ($user->role == "Student")
                                               border-green-400
                                            @elseif ($user->role == "Administrator")
                                                border-blue-400
                                            @elseif ($user->role == "Alumni")
                                                border-purple-400
                                            @elseif ($user->role == "Office")
                                                border-yellow-400 
                                            @endif
                                                my-4 flex items-center justify-between rounded-l-lg"
                                                data-user-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                data-role="{{ $user->role }}">
                                                <div class="w-1/4 py-4 px-6 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if(empty($user->profile_picture))
                                                                <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $user->name }}">
                                                            @else
                                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}">
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ Str::limit($user->name, 23, '...') }}
                                                            </div>                                                            
                                                            <div class="text-sm text-gray-500">
                                                                <span class="
                                                                    @switch($user->role)
                                                                        @case('Administrator')
                                                                            text-blue-600
                                                                        @case('Office')
                                                                            text-yellow-600
                                                                        @case('Student')
                                                                            text-green-600
                                                                        @case('Alumni')
                                                                            text-purple-600
                                                                        @default
                                                                            text-gray-600
                                                                    @endswitch
                                                                ">
                                                                    {{ $user->role }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-1/2 py-4 px-6 md:block hidden max-md:hidden">
                                                    <div class="text-sm text-gray-900 font-medium">{{ $user->email }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $user->student_id ?: $user->user_code }}
                                                    </div>
                                                </div>
                                                <div class="w-1/4 py-4 px-6 whitespace-nowrap text-right text-sm font-medium">
                                                    <span class="text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                                                </div>
                                            </a>
                                            @empty
                                            <div class="no-results">
                                                <div class="p-10 text-center">
                                                    <img src="{{ asset('images/bot.png') }}" width="200" alt="No users" class="opacity-50 mx-auto mb-4">
                                                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                        No {{ isset($loop->parent) && $loop->parent->first ? $data['label'] : '' }} users found.
                                                    </h2>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @if (Session::has('message'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ Session::get('message') }}', 
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 px-4 py-2 rounded'
                    }
                });
            </script>
        @endif

        <div id="addUserTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div id="formUser"  class="bg-white rounded-lg shadow-lg" style="width: 400px; max-width: 90vw;">
                <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-6 border">
                    <h2 class="text-2xl font-semibold mb-6">Add New Account</h2>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
                            <select name="role" id="role" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                                <option value="">Select Role</option>
                                <option value="Administrator">Admin</option>
                                <option value="Office">Office Head</option>
                                {{-- <option value="Student">Student</option>
                                <option value="Alumni">Alumni</option> --}}
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- only shows if the selected role is Alumni or Student --}}
                        {{-- <div class="mb-4">
                            <label for="student_id" class="block text-gray-700 font-semibold mb-2">Student ID</label>
                            <input type="text" name="student_id" id="student_id" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('student_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}
                    
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                            <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                            <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                                        
                        <div class="flex items-center justify-between">
                            <x-primary-button type="submit">
                                Create Account
                            </x-primary-button>
                            <a href="#" onclick="hideAddUserTab()" class="text-gray-800 hover:text-indigo-600 font-semibold">Cancel</a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const $slider = $('.user-tab-slider');

        function moveSlider($activeTab) {
            const left = $activeTab.position().left;
            const width = $activeTab.outerWidth();
            $slider.css({
                left: left,
                width: width
            });
        }

        const $initialActiveTab = $('.user-tab.active');
        moveSlider($initialActiveTab);

        $('.user-tab').click(function(e) {
            e.preventDefault();
            const $clickedTab = $(this);
            var targetId = $(this).attr('id') + 'box';
            $('.user-tab').removeClass('active');
            $clickedTab.addClass('active');
            const $slider = $('.user-tab-slider');
            const left = $clickedTab.position().left || 0;
            const width = $clickedTab.outerWidth() || 0;
            
            if (width > 0) {
                $slider.css({
                    left: left,
                    width: width,
                });
            }

            $(this).removeClass('inactive').addClass('active');
            $('.user-content').addClass('hidden');
            $('#' + targetId).removeClass('hidden');
            $('#user-search').val(''); // Clear search input when changing tabs
            filterUsers(''); // Show all users in the new tab
            moveSlider($clickedTab);
        });

        $('.clickable').click(function() {
            var url = $(this).attr('href');
            if (url) {
                window.location.href = url;
            }
        });

        $('#user-search').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            filterUsers(searchTerm);
        });

        function filterUsers(searchTerm) {
            var activeTab = $('.user-tab.active').attr('id') + 'box';
            var visibleRows = 0;

            $('#' + activeTab + ' .clickable').each(function() {
                var row = $(this);
                var userId = row.data('user-id').toString();
                var name = row.data('name').toLowerCase();
                var email = row.data('email').toLowerCase();
                var role = row.data('role').toLowerCase();

                // Remove existing highlights
                row.find('.highlight').contents().unwrap();

                if (userId.includes(searchTerm) || name.includes(searchTerm) || 
                    email.includes(searchTerm) || role.includes(searchTerm)) {
                    row.removeClass('hidden');
                    visibleRows++;
                    
                    // Highlight matching text
                    highlightText(row.find('.text-sm'), searchTerm);
                } else {
                    row.addClass('hidden');
                }
            });

            // Show or hide the "No results" message
            if (visibleRows === 0) {
                $('#' + activeTab + ' .no-results').removeClass('hidden');
            } else {
                $('#' + activeTab + ' .no-results').addClass('hidden');
            }
        }

        function highlightText(elements, searchTerm) {
            elements.each(function() {
                var element = $(this);
                var text = element.text();
                var regex = new RegExp('(' + escapeRegExp(searchTerm) + ')', 'gi');
                var newText = text.replace(regex, '<span class="highlight">$1</span>');
                element.html(newText);
            });
        }

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }
    });
</script>

<style>
    .user-tab-container {
        position: relative;
        display: flex;
        justify-content: start;
        border-bottom: 2px solid #fff;
    }

    .user-tab {
        position: relative;
        color: #6b7280;
        padding: 0.5rem 1rem;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .user-tab:hover {
        color: #4b5563;
    }

    .user-tab.active {
        color: #2563eb;
        font-weight: 600;
    }

    .user-tab-slider {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        width: 0;
        background-color: #2563eb;
        transition: all 0.3s ease;
    }

    .clickable {
        transition: all 0.2s ease-in-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .clickable:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .table-data::-webkit-scrollbar {
        width: 6px;
    }
    .table-data::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .table-data::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    .table-data::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .highlight {
        background-color: yellow;
        font-weight: bold;
    }
</style>




<script>
    function addUserTab() {
        const addUserTab = document.getElementById('addUserTab');
        const formUser = document.getElementById('formUser');
        addUserTab.style.display = 'flex';
        addUserTab.classList.add('animated-pulse');
    }
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' || event.keyCode === 27) {
            hideAddUserTab();
        }
    });

    function hideAddUserTab() {
        const addUserTab = document.getElementById('addUserTab');
        const formUser = document.getElementById('formUser');
        addUserTab.classList.add('animated-vanish');
        formUser.classList.add('animated-close');

        setTimeout(() => {
            addUserTab.style.display = 'none';
            addUserTab.classList.remove('animated-pulse');
            formUser.classList.remove('animated-close');
            addUserTab.classList.remove('animated-vanish');
        }, 300);
    }    



</script>

<style>
    /* Tailwind CSS utility classes */

    .custom-shadow {
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.2);
    }

    /* Additional CSS styles */
    .animated-hover {
        transition: transform 0.2s ease-in-out;
    }

    .animated-hover:hover {
        transform: scale(1.05);
    }

    .animated-pulse {
        animation: pulse 0.3s ease-in-out;
    }

    .animated-close {
        animation: close 0.3s ease-in-out;
    }

    .animated-vanish {
        animation: vanish 0.3s ease-in-out;
    }

    .animated-pulsesss {
        animation: pulsesss 0.2s ease-in-out;
    }

    .animated-closesss {
        animation: closesss 0.2s ease-in-out;
    }

    .animated-vanishsss {
        animation: vanishsss 0.2s ease-in-out;
    }

    @keyframes showUp {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes pulse {
        0% {
            opacity: 0;
            scale: 0.7;
        }
        50% {
            scale: 1.1;
        }
        100% {
            opacity: 1;
            scale: 1;
        }
    }

    @keyframes close {
        0% {
            scale: 1;
            opacity: 1;
        }
        50% {
            scale: 1.1;
            opacity: 1;
        }
        100% {
            scale: 0.7;
            opacity: 0;
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

    @keyframes pulsesss {
        0% {
            opacity: 0;
            scale: 0.95;
        }
        100% {
            opacity: 1;
            scale: 1;
        }
    }

    @keyframes closesss {
        0% {
            scale: 1;
            opacity: 1;
        }
        100% {
            scale: 0.9;
            opacity: 0;
        }
    }

    @keyframes vanishsss {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

</style>

