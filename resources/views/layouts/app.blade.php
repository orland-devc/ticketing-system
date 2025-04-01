<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta property="og:title" content="Your Website Title">
        <meta property="og:description" content="A short description of your website.">
        <meta property="og:image" content="{{ asset('images/system logo.png') }}">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:type" content="website">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons/dist/ionicons/ionicons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> --}}
        

        <link rel="icon" href="{{ asset('images/system logo no bg 3.png') }}" type="image/x-icon">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100">
        <div class="max-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
            <header id="header" class=" select-none shadow bg-white sm:ml-[80px] md:ml-[80px] lg:ml-[258px]">
                <div id="header1" class="mx-auto py-3 px-6 flex items-center justify-between">
                    {{ $header }}
                    <div class="flex items-center side-header select-none">
                        <button class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-medium flex gap-2 items-center">
                            <i class="fas fa-bell"></i> 
                            <p class="hidden md:block lg:block xl:block">Notifications</p>
                        </button>
                        <a href="#" id="profile_pic" onclick="toggleProfile()">
                            <img class="h-8 w-8 rounded-full ml-4 hover:border-blue-500 border-2 transition all duration-300" src="{{ asset(Auth::user()->profile_picture) }}" alt="User avatar">
                        </a>
                    </div>
                </div>
            </header>
            @endif

            <!-- Page Content -->
            <main id="mainContent" class="mt-0 sm:ml-[80px] md:ml-[80px] lg:ml-[258px] max-h-screen">
                {{ $slot }}
            </main>
        </div>

        <div id="profile_areas" class="fixed top-20 right-5 w-80 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden hidden">
            <div class="relative pb-20 mb-12">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-gray-900"></div>
                <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile Picture" class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-24 h-24 rounded-full border-4 border-white shadow-lg">
            </div>
            <div class="px-6 pb-6">
                <h2 class="text-2xl font-bold text-center text-gray-800">{{ Auth::user()->name }}</h2>
                <p class="text-center text-gray-600 mb-2">{{ Auth::user()->role }}</p>
                <p class="text-center text-gray-500 mb-4">{{ Auth::user()->email }}</p>
                <div class="flex flex-col space-y-2">
                    <a href="/manage-profile" class="block w-full py-2 px-4 bg-gray-800 text-white text-center font-semibold rounded-md hover:bg-gray-700 transition duration-200">Manage Profile</a>
                    <a href="/logout" class="block w-full py-2 px-4 bg-red-500 text-white text-center font-semibold rounded-md hover:bg-red-600 transition duration-300">Log Out</a>
                </div>
            </div>
        </div>

        <div id="profile_area" class=" select-none fixed top-14 right-5 w-80 bg-white rounded-lg shadow-2xl border border-gray-200 overflow-hidden hidden" style="z-index: 55;">
            <div id="profile_form">
                <div class="relative pb-20 mb-14">
                    <div class="absolute inset-0 animate-gradient"></div>
                    <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile Picture" class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-24 h-24 rounded-full border-4 border-white shadow-lg">
                </div>
                <div class="pb-6">
                    <h2 class="text-xl mb-2 font-bold text-center text-gray-900">{{ Auth::user()->name }}</h2>
                    <p class="text-center text-gray-600 mb-2">{{ Auth::user()->role }}</p>
                    {{-- <p class="text-center text-gray-500 mb-4">{{ Auth::user()->email }}</p> --}}
                    <div class="flex border-t-2 flex-col">
                        <a href="/account" class="flex items-center w-full py-2 px-4 bg--100 text-gray-900 text-center font-semibold hover:bg-blue-200 transition duration-300">
                            <ion-icon name="person-circle" class="text-2xl mr-3 text-gray-400"></ion-icon>
                            Go to Profile
                        </a>
                        <a href="/profile" class="flex items-center w-full py-2 px-4 bg--100 text-gray-900 text-center font-semibold hover:bg-blue-200 transition duration-300">
                            <ion-icon name="settings" class="text-2xl mr-3 text-gray-400"></ion-icon>
                            Account Settings
                        </a>
                        <a href="/analytics" class="flex items-center w-full py-2 px-4 bg--100 text-gray-900 text-center font-semibold hover:bg-blue-200 transition duration-300">
                            <ion-icon name="analytics" class="text-2xl mr-3 text-gray-400"></ion-icon>
                            Analytics
                        </a>
                        <a href="/help-support" class="flex items-center w-full py-2 px-4 bg--100 text-gray-900 text-center font-semibold hover:bg-blue-200 transition duration-300">
                            <ion-icon name="time" class="text-2xl mr-3 text-gray-400"></ion-icon>
                            Recent Activity & Usage
                        </a>
                        <a href="#" onclick="toggleLogout()" class="block mx-4 mt-2 py-2 px-4 bg-gray-900 text-white text-center font-semibold rounded-md hover:bg-gray-800 transition duration-300">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>

<style>
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-gradient {
        background: linear-gradient(-45deg, #000000, #000436, #003575, #0054ba);
        background-size: 400% 400%;
        animation: gradient 10s ease infinite;
    }
    
    #header {
        position: sticky;
        top: 0;
        z-index: 50; /* Ensures the header stays above other elements */
    }

    .mainContents {
        margin-left: 258px
    }
    body {
        font-family: Poppins;
    }
    h2 ion-icon {
        font-size: 25px;
        position: relative;
        top: 5px;
    }
    th {
        background: #e5e7eb;
    }
    th, td {
        border: 1px solid #bbb;
    }
    td .view {
        padding: 5px 8px;
        background: #6366f1;
        border-radius: 8px;
        color: white;
    }
    td .delete {
        padding: 5px 8px;
        background: #ff0000;
        border-radius: 8px;
        color: white;
    }
    td a {
        margin: 0 8px;
        transition: background-color 0.3s ease;
    }
    td a ion-icon {
        font-size: 20px;
        margin: 0 15px;
        position: relative;
        top: 5px;
    }

    .action {
        position: relative;
        top: 3px;
        font-size: 20px;
    }
    .none {
        border: none;
        border-bottom: 1px solid #c8c8c8;
    }
    .clickable-row:hover {
        cursor: pointer;
        background-color: rgb(225, 225, 225);
    }

    .primary_button {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px; /* Adjust padding as needed */
        background-color: #1f2937; /* Use your desired gray color */
        border: 1px solid transparent; /* Use your desired border color */
        border-radius: 0.375rem; /* Adjust border radius as needed */
        font-weight: 600; /* Use your desired font weight */
        font-size: 0.75rem; /* Use your desired font size */
        line-height: 1.25; /* Adjust line height as needed */
        color: #fff; /* Use your desired text color */
        text-transform: uppercase;
        letter-spacing: 0.05em; /* Adjust letter spacing as needed */
        cursor: pointer;
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
    }

    .primary_button:hover,
    .primary_button:focus {
        background-color: #343f51; /* Use your desired hover background color */
        border-color: #2d3748; /* Use your desired hover border color */
    }

    .primary_button:active,
    .primary_button:focus {
        background-color: #1a202c; /* Use your desired active background color */
        border-color: #1a202c; /* Use your desired active border color */
    }

</style>

<script>
    var msg='{{Session::get('success')}}';
    var exist='{{Session::has('success')}}';
    if (exist) {
        alert(msg);
    }
</script>

<style>
    .botNav {
        width: 280px;
    }

    .mainContent-expand {
        padding-left: 72px;
        transition: padding-left 0.3s ease-in-out; 
    }

    .sidebar-collapsed {
        max-width: 72px;
        transition: max-width 0.3s ease-in-out;
    }

    .sidebar-collapsed nav a span {
        display: none;
    }

    .sidebar-collapsed nav a i {
        margin-right: 0 !important;
    }

</style>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.bg-gray-800.h-screen.max-w-72.border-r.border-gray-500');
        const botNav  = document.getElementById("botNav");
        const header = document.getElementById("header");
        const mainContent = document.getElementById("mainContent");

        botNav.classList.toggle('sidebar-collapsed');
        sidebar.classList.toggle('sidebar-collapsed');
        header.classList.toggle('mainContent-expand');
        mainContent.classList.toggle('mainContent-expand');
    }
    function openProfile() {
        const profileImage = document.getElementById('openProfile')

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
        animation: pulsesss 0.2s ease-out;
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
            scale: 0.95;
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












<script>
    function toggleProfile() {
    const profile_area = document.getElementById('profile_area');

    event.stopPropagation();

    if (profile_area.classList.contains('hidden')) {
        profile_area.classList.remove('hidden');
        profile_area.classList.add('animated-pulsesss');
    } else {
        hideProfile();
    }
}

    function hideProfile() {
        const profile_area = document.getElementById('profile_area');
        profile_area.classList.add('animated-closesss');

        setTimeout(() => {
            profile_area.classList.add('hidden')
            profile_area.classList.remove('animated-pulsesss');
            profile_area.classList.remove('animated-closesss');
        }, 180);
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' || event.keyCode === 27) {
            hideProfile();
        }
    });

    document.addEventListener('click', function(event) {
        const profile_area = document.getElementById('profile_area');
        const isClickInside = profile_area.contains(event.target);
        const isClickToggle = document.getElementById('mainContent').contains(event.target);

        if (!isClickInside && !isClickToggle) {
            hideProfile();
        }
    });
</script>