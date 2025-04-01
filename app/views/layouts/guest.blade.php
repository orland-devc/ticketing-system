<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background-image: url('/images/psuscschool.jpg'); background-size: cover; position: relative; background-repeat: no-repeat;">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, rgba(62, 89, 240, 0.85), rgba(84, 159, 232, 0.85));">
            <div class="mt-0"> <!-- Adjust the margin-top here -->
                <a href="/login">
                    <img src="/images/PSU logo.png" alt="PSU Logo" class="w-20 h-20 border-3 border-white rounded-full border-solid" />

                </a>
            </div>            
            
            <div class="w-full sm:max-w-md mt-2 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"> <!-- Adjusted margin-top -->
                {{ $slot }}
            </div>
            
        </div>
    </body>
</html>
