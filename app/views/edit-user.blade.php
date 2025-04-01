@section('title', 'User Details')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }} {{$user->id}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Edit User</h2>
                </div>
                <div class="px-6 py-4">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Password</label>
                            <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('passowrd')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
                            <select name="role" id="role" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Select Role</option>
                                <option value="Administrator" {{ $user->role === 'Administrator' ? 'selected' : '' }}>Admin</option>
                                <option value="Office" {{ $user->role === 'Office' ? 'selected' : '' }}>Staff</option>
                                <option value="Student" {{ $user->role === 'Student' ? 'selected' : '' }}>Student</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Add more form fields as needed -->

                        <div class="flex items-center justify-between">
                            <div>
                                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold mr-2 py-2 px-4 rounded-md">
                                    Save Changes
                                </button>
                                <form action="{{route('users.destroy', $user->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md">
                                        Delete Account
                                    </button>
                                </form>
                            </div>
                            

                            <a href="http://127.0.0.1:8000/UserManagement" class="text-indigo-500 hover:text-indigo-600 font-semibold">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
