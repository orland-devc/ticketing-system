<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ticket Auto-Assigning') }}
                <ion-icon name="people" class="ml-2 text-2xl"></ion-icon>
                <a href="http://127.0.0.1:8000/tickets" class="ml-4 font-normal text-lg text-blue-400 hover:underline hover:text-blue-600 cursor-pointer">
                    Back to Tickets 
                    <ion-icon name="arrow-forward"></ion-icon>
                </a>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Create Ticket Category</h2>
            </div>

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

            <!-- Error message -->
            @if($errors->any())
                <script>
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Unexpected error!',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-500 text-white hover:bg-red-600 focus:ring-2 focus:ring-red-300 px-4 py-2 rounded'
                        }
                    });
                </script>
            @endif

            <form action="{{ route('ticket_category.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        placeholder="Enter category name" 
                        value="{{ old('name') }}" 
                        required 
                        autocomplete="off"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label for="office_id" class="block text-sm font-medium text-gray-700 mb-2">Assigned Office</label>
                    <select 
                        name="office_id" 
                        id="office_id" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">Select Office</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                    >
                        Create Category
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Categories Section -->
        <div class="mt-8 bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Existing Ticket Categories</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Office</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->office->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a 
                                        href="{{ route('ticket_category.edit', $category->id) }}" 
                                        class="text-blue-600 hover:text-blue-900 mr-3"
                                    >
                                        Edit
                                    </a>
                                    <form 
                                        action="{{ route('ticket_category.destroy', $category->id) }}" 
                                        method="POST" 
                                        class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
