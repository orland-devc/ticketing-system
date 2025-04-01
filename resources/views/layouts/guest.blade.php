<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <link rel="icon" href="{{ env('APP_LOGO3') }}" type="image/x-icon">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100 to-gray-50 overflow-hidden">
        <!-- Background container (hidden on mobile) -->
        <div class="hidden sm:block fixed inset-0 z-0 right-[-4vh]">
            <img src="/images/psuscschool.jpg" 
                 alt="Background" 
                 class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>
        </div>

        <!-- Content wrapper -->
        <div class="relative z-10 min-h-screen flex flex-col sm:mt-24 items-center">
            <!-- Logo -->
            <div class="my-2 sm:mt-0 sm:mb-4">
                <a href="/login">
                    <img src="{{ asset('images/system logo.png') }}" 
                         alt="PSU Logo" 
                         class="w-28 sm:w-44 h-28 sm:h-44 sm:hidden block rounded-full shadow-2xl border-white border-4"
                    />
                    <img src="{{ asset('images/system logo no bg.png') }}" 
                         alt="PSU Logo" 
                         class="w-24 sm:w-44 h-24 sm:h-44 sm:block hidden "
                    />
                </a>
            </div>            
            
            <!-- Main content -->
            <div class="w-11/12 sm:max-w-md mt-2 px-6 py-2 bg-white shadow-lg sm:shadow-md overflow-hidden rounded-2xl sm:rounded-lg border border-gray-100">
                {{ $slot }}
            </div>
            
            <!-- Footer Navigation -->
            <footer class="absolute bottom-10 left-0 right-0 border-t border-gray-200 bg-white sm:hidden">
                <nav class="flex flex-wrap justify-center items-center gap-4 text-sm text-gray-600 py-4">
                    <a href="{{ route('register') }}" class="hover:text-gray-900">Sign Up</a>
                    <a href="{{ route('login') }}" class="hover:text-gray-900">Log In</a>
                    <a href="/chatbot" class="hover:text-gray-900">Chatbot</a>
                    <a href="/helpdeskpro" class="hover:text-gray-900">HelpDeskPro</a>
                </nav>
            </footer>
        </div>


    </body>
</html>