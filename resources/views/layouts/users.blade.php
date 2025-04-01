<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons/dist/ionicons/ionicons.js"></script>
        <link rel="icon" href="{{ asset('images/system logo no bg 3.png') }}" type="image/x-icon">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen bg-white">
            @include('layouts.navigations')

            <!-- Page Heading -->
            @if (isset($header))
            <header id="header" class=" select-none shadow bg-white sm:ml-[80px] md:ml-[80px] lg:ml-[258px]">
                <div class="mx-auto py-4 px-3 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main id="mainContent" class="mt-0 sm:ml-[80px] md:ml-[80px] lg:ml-[258px] max-h-screen">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

<style>
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
</style>

<style>
    /* Tailwind CSS utility classes */
    .top-option {
        @apply px-3 py-2 rounded-full transition-colors duration-200 text-gray-600 hover:text-blue-500;
    }

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

    .animated-show {
        /* animation: showUp 0.3s ease-in-out; */
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
</style>

<style>
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