@section('title', 'User - ' . $user->name)

<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profile') }} <ion-icon name="person-circle-outline"></ion-icon>
    </h2>
</x-slot>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <!-- Header with user basic info -->
        <div class="flex items-center border-b pb-6">
            <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden">
                @if($user->profile_picture)
                    <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}'s photo" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-300">
                        <span class="text-2xl text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
            <div class="ml-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $user->name }}
                   <span class="text-xl"> ({{ $user->student_id ?: $user->user_code }}) </span>
                </h1>                
                <p class="text-gray-600">{{ $user->email }}</p>
                <p class="text-sm text-gray-500">Member since {{ $user->created_at->format('M Y') }}</p>
            </div>
        </div>

        <!-- User details -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-900">Personal Information</h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Phone</label>
                    <p class="mt-1">{{ $user->phone ?? 'Not provided' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Address</label>
                    <p class="mt-1">{{ $user->address ?? 'Not provided' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Bio</label>
                    <p class="mt-1">{{ $user->bio ?? 'No bio available' }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-900">Account Information</h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Role</label>
                    @if ($user->role === 'Office')
                        <p class="mt-1">Office Head</p>
                    @else 
                        <p class="mt-1">{{ ucfirst($user->role) }}</p>
                    @endif
                    
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Status</label>
                    <span class="px-2 py-1 text-sm rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Last Login</label>
                    <p class="mt-1">
                        @if ($user->last_login_at && $user->last_login_at->created_at)
                            {{ $user->last_login_at->created_at->diffForHumans() }}
                        @else
                            Never
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="mt-8 flex justify-end space-x-4">
            @can('update', $user)
                <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Edit Profile
                </a>
            @endcan
            
            <a href="{{ route('manage.users') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                Back to Users
            </a>
        </div>
    </div>
</div>
</x-app-layout>