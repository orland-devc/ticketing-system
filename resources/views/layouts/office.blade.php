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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <link rel="icon" href="{{ asset('images/system logo no bg 3.png') }}" type="image/x-icon">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"></script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen bg-white">
            @include('layouts.officeNav')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="shadow pl-72" style="margin-top: -3px; background: #fff;">
                    <div class="mx-auto py-4 px-3 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="mt-0 pl-72">
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

<script>
    var msg='{{Session::get('success')}}';
    var exist='{{Session::has('success')}}';
    if (exist) {
        alert(msg);
    }
</script>