{{-- resources/views/unavailable.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currently Unavailable | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="fixed inset-0 bg-[url('/public/img/grid.svg')] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
    
    <div class="relative min-h-screen flex flex-col items-center justify-center p-8">
        <!-- Logo Area -->
        <div class="mb-8">
            <a href="{{ url('/') }}" class="inline-block">
                <img src="{{ asset('logo.svg') }}" alt="{{ config('app.name') }}" class="h-12">
            </a>
        </div>

        <!-- Main Content -->
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-12 max-w-2xl w-full mx-auto border border-gray-100">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-6">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <h1 class="text-3xl font-semibold text-gray-900 mb-3">
                    Currently Unavailable
                </h1>
                
                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    We're working on bringing this section online. Please check back later or contact our support team for assistance.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                        Return Home
                    </a>
                    <a href="{{ url('/contact') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                        Contact Support
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>