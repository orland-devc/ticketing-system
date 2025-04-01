@props(['user'])

<span class="inline-flex items-center">
    <span class="w-2 h-2 rounded-full mr-2 {{ $user->isOnline() ? 'bg-green-500' : 'bg-gray-500' }}"></span>
    {{ $user->isOnline() ? 'Online' : 'Offline' }}
</span>