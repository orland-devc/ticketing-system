<nav x-data="{ open: false }" class="bg-blue-700 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="flex fixed">
        <!-- Sidebar -->
        <div class="bg-gray-800 h-screen w-72 border-r border-gray-500">
            <div id="side-bar" class="flex flex-col mt-4">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mx-3 px-2 pb-4 border-b-2 border-gray-500 mr-3">
                    <a href="{{ route('officedashboard') }}" class="mr-3">
                        <img src="{{ asset('images/system logo no bg 2.png') }}" alt="PSU Logo" class="h-10 w-10 border-2 border-yellow-500 rounded-full scale-[1.2]" />
                    </a>
                    {{-- <a href="#" id="menu" class="text-3xl text-white ml-20 hover:bg-gray-700 py-2 px-4 rounded-full" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </a> --}}
                    <span class="text-xl font-semibold tracking-wide text-white">Office Head</span>

                </div>

                @php
                // Get the current route name
                    $currentRoute = request()->route()->getName();

                    // Define an array of keywords to match for the "Tickets" link
                    $ticketsKeywords = 'tickets';

                    // Check if the current route matches the tickets route or contains any of the keywords
                    $isActiveTickets = $currentRoute === 'assigned-tickets' || Str::contains($currentRoute, $ticketsKeywords);

                    // Define an array of keywords to match for the "User Management" link
                    $userManagementKeywords = ['User', 'users'];

                    // Check if the current URI contains any of the user management keywords
                    $isActiveUserManagement = Str::contains(request()->path(), $userManagementKeywords);
                @endphp

                <!-- Navigation Links -->
                <nav class="flex-grow space-y-2 p-3">
                    <x-nav-link :href="route('officedashboard')" :active="$currentRoute === 'officedashboard'" class="x-nav-link mb-2 block">
                        <i class="fas fa-home my-auto mr-5"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('messages.index')" :active="$currentRoute === 'messages.index'">
                        <ion-icon name="chatbubbles" class="my-auto mr-5 text-xl"></ion-icon>
                        <span class="spanned">{{ __('Messages') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('assigned-tickets')" :active="$isActiveTickets">
                        <i class="fas fa-ticket-alt my-auto mr-5"></i>
                        {{ __('Tickets') }}
                        @if ($office_unread_tickets == 0)
                        @else
                            <span class="absolute right-2 bg-red-500 text-sm text-white px-2 rounded-full ml-24">{{$office_unread_tickets}}</span>
                        @endif
                    </x-nav-link>

                    @if (Auth::user()->name == "MIS")
                        <x-nav-link :href="route('mis.requests')" :active="request()->routeIs('mis.requests')" class="x-nav-link mb-2 block">
                            <i class="fas fa-users my-auto mr-5"></i>
                            {{ __('Signup Requests') }}
                            @if ($requestNum == 0)
                        @else
                        <span class="absolute right-2 bg-red-500 text-sm text-white px-2 rounded-full ml-24">{{$requestNum}}</span>
                        @endif
                        </x-nav-link>                        
                    @endif
                </nav>
            </div>

            <nav id="botNav" class="mt-1 space-y-2 ml-0 border-t-2 border-gray-500 absolute bottom-5 botNav p-1 w-72 px-2" style="">
                <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    <i class="fas fa-user mr-5"></i>
                    <span>{{ __('Profile') }}</span>
                </x-nav-link>

                <!-- Authentication -->
                <x-nav-link href="#" onclick="toggleLogout()">
                    <i class="fas fa-sign-out-alt mr-5"></i>
                    <span>{{ __('Logout') }}</span>
                </x-nav-link>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-4">
            <!-- Here goes your main content -->
        </div>
    </div>
    <div class="hidden sm:flex sm:items-center sm:ms-6 absolute right-8 top-4 sm:hidden">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent leading-4 font-medium rounded-md text-black focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content" class="fixed" style="z-index: 999;">
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

</nav>

<div id="logoutTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
    <div id="form_out"  class="bg-white rounded-lg shadow-lg" style="width: 400px; max-width: 90vw;">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Are you sure you want to logout?</h3>
            </div>
            <div><br>
                <form method="POST" action="{{ route('logout') }} " class="grid grid-cols-2 gap-6">
                    @csrf
                    <a href="#" onclick="hideLogout()" class="bg-gray-200 hover:bg-gray-300 border px-4 py-2 text-center rounded-lg">Cancel</a>
                    <a href="route('logout')" class="bg-blue-500 hover:bg-blue-600 border px-4 py-2 text-center text-white rounded-lg"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                        <span>{{ __('Log Out') }}</span>
                    </a>
                </form>    
            </div>
        </div>
    </div>
</div>


<script>

    function toggleLogout() {
        const logoutTab = document.getElementById('logoutTab');
        const form = document.getElementById('form_out');

        logoutTab.style.display = "flex";
        logoutTab.classList.add('animated-show');
        form.classList.add('animated-pulse');
    }

    function hideLogout() {
        const logoutTab = document.getElementById('logoutTab');
        const form = document.getElementById('form_out');
        logoutTab.classList.add('animated-vanish');
        form.classList.add('animated-close');

        setTimeout(() => {
            logoutTab.style.display = 'none';
            logoutTab.classList.remove('animated-pulse');
            form.classList.remove('animated-close');
            logoutTab.classList.remove('animated-vanish');
        }, 300);
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' || event.keyCode === 27) {
            hideLogout();
        }
    });
</script>