<nav x-data="{ open: false }" class="bg-blue-700 border-b border-gray-100 select-none">
    <!-- Primary Navigation Menu -->
    <div class="flex fixed">
        <!-- Sidebar -->
        <div class="bg-gray-800 h-screen border-r border-gray-500 navigations hidden sm:block md:block lg:block xl:block sm:w-20 md:w-20 lg:w-64 xl:w-64">
            <div id="side-bar" class="flex flex-col mt-4">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mx-3 px-2 pb-4 border-b-2 border-gray-500 mr-3">
                    <a href="{{ route('admindashboard') }}" class="mr-3 flex items-center gap-3">
                        <img src="{{ asset('images/system logo no bg.png') }}" alt="PSU Logo" class="h-10 w-10 border-2 border-blue-500 rounded-full scale-[1.2]" />
                        <span class="text-xl font-semibold tracking-wide text-white">Administrator</span>
                    </a>
                </div>

                @php
                    $currentRoute = request()->route()->getName();
                    $ticketsKeywords = ['tickets', 'ticket'];
                    $isActiveTickets = $currentRoute === 'tickets.index' || Str::contains($currentRoute, $ticketsKeywords);
                    $userManagementKeywords = ['user', 'users'];
                    $isActiveUserManagement = Str::contains(request()->path(), $userManagementKeywords);
                @endphp

                <!-- Navigation Links -->
                <nav class="flex-grow space-y-2 p-3">
                    <x-nav-link :href="route('admindashboard')" :active="$currentRoute === 'admindashboard'">
                        <i class="fas fa-home my-auto mr-5"></i>
                        <span class="spanned">{{ __('Dashboard') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('messages.index')" :active="$currentRoute === 'messages.index'">
                        <ion-icon name="chatbubbles" class="my-auto mr-5 text-xl"></ion-icon>
                        <span class="spanned">{{ __('Messages') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('tickets.index')" :active="$isActiveTickets">
                        <ion-icon name="ticket" class="my-auto mr-5 text-xl"></ion-icon>
                        <span class="spanned">{{ __('Tickets') }}</span>
                        @if ($unread_tickets != 0)
                            <div class="absolute bg-red-500 text-sm text-white px-2 rounded-full ml-24 spanned right-2">{{$unread_tickets}}</div>
                        @endif
                    </x-nav-link>
                    <x-nav-link :href="route('manage-chatbot.index')" :active="$currentRoute === 'manage-chatbot.index'">
                        <ion-icon name="logo-flickr" class="my-auto mr-5 text-xl"></ion-icon>
                        <span class="spanned">{{ __('Chatbot') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('manage.users')" :active="$isActiveUserManagement">
                        <i class="fas fa-users my-auto mr-5"></i>
                        <span class="spanned">{{ __('User Management') }}</span>
                    </x-nav-link>
                </nav>
            </div>

        </div>
    </div>
</nav>

<div class="hidden sm:items-center sm:ms-6 absolute right-8 top-4 sm:hidden">
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

<div id="logoutTab" class="fixed inset-0 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none; z-index: 60;">
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