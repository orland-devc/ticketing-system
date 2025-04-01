@section('title', 'PSU Login')

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Success message -->
    @if(session('message'))
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

    <form method="POST" action="{{ route('login') }}" class="mt-5">
        @csrf

        <h2 class="flex justify-center font-bold text-lg pb-2">
            Log Into PSU HelpDeskPro
        </h2>

        <!-- Email Address -->
        <div class="mb-4">
            {{-- <h1 style="margin-top: -1px; margin-bottom: 20px; font-weight: bold; font-size: 20px; text-align: center">LOGIN</h1> --}}
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Login Button -->
        <div class="mb-4">
            <x-primary-button class="flex items-center justify-center mr-4 w-full h-11">
                {{ __('Log in') }}
            </x-primary-button>
            
        </div>
        
        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
            <div class="flex justify-between items-center mb-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                <div>
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                        {{ __('Create account') }}
                    </a>
                </div>
            </div>
        @endif

    </form>
</x-guest-layout>
