@section('title', 'Submit New Ticket')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit a Ticket') }} &nbsp;<ion-icon name="ticket"></ion-icon>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            {{-- <input type="text" name="user_id" value="{{ Auth::user()->id }}" hidden> --}}
                            <div class="mb-4">
                                <label for="subject" class="block text-gray-700 font-bold mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('subject')
                                    <p class="text-red-500 text-xs italic mt-2">hello</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                                {{-- <input type="text" id="category" name="category" value="{{ old('subject') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required> --}}
                                {{-- <select id="category" name="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                    <option>HAHA</option>
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select> --}}
                                <select id="ticketCategory" name="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="">Select Category</option>
                                    <option value="Admissions">Admissions</option>
                                    <option value="Academic Affairs">Academic Affairs</option>
                                    <option value="Financial Aid">Financial Aid</option>
                                    <option value="Scholarships">Scholarships</option>
                                    <option value="IT Support">IT Support</option>
                                    <option value="Student Services">Student Services</option>
                                    <option value="Faculty/Staff Support">Faculty/Staff Support</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Feedback/Suggestions">Feedback/Suggestions</option>
                                </select>
                                
                                @error('category_id')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="content" class="block text-gray-700 font-bold mb-2">Description</label>
                                <textarea id="content" name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="attachments" class="block text-gray-700 font-bold mb-2">Attachments (optional)</label>
                                <input type="file" id="attachments" name="attachments[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                                @error('attachments')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Submit Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


