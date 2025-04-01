<nav x-data="{ open: false }" class="bg-blue-600 border-b border-gray-100">
{{-- <nav x-data="{ open: false }" class="bg-indigo-500 border-b border-gray-100 fixed w-full top-0 z-10"> --}}

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admindashboard') }}">
                        <img src="/images/PSU logo.png" alt="PSU Logo" class="block h-12 w-auto border-2 border-white rounded-full" />
                    </a>
                </div>
                

                <!-- Navigation Links -->
                <div class="hidden space-x-0 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('admindashboard')" :active="request()->routeIs('admindashboard')" class="x-nav-link">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admindashboard')" :active="request()->routeIs('messages')" class="x-nav-link">
                        {{ __('Messages') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index')" class="x-nav-link">
                        {{ __('Tickets') }}
                    </x-nav-link>                    
                    <x-nav-link :href="route('admindashboard')" :active="request()->routeIs('reports')" class="x-nav-link">
                        {{ __('Reports') }}
                    </x-nav-link>
                    <x-nav-link :href="route('chatbot')" :active="request()->routeIs('chatbot')" class="x-nav-link">
                        {{ __('Chatbot') }}
                    </x-nav-link>
                    {{-- <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile')" class="x-nav-link">
                        {{ __('Settings') }}
                    </x-nav-link>                     --}}

                    {{-- <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile')">
                        {{ __('Profile') }}
                    </x-nav-link>

                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('settings')">
                        {{ __('Settings') }}
                    </x-nav-link> --}}

                    <!-- Add as many navigation links as needed -->
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent leading-4 font-medium rounded-md text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-blue-400 focus:outline-none focus:bg-blue-200 focus:text-blue-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="white" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('messages')">
                {{ __('Messages') }}
            </x-responsive-nav-link>
            <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index')" class="x-nav-link">
                {{ __('Tickets') }}
            </x-nav-link>                    
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('settings')">
                {{ __('Reports') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('chatbot')" :active="request()->routeIs('settings')">
                {{ __('Chatbot') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    .x-nav-link {
        color: white;
    }
</style>