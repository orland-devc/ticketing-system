@section('title', 'Submit New Ticket')

<x-users-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Submit a Ticket') }} &nbsp;<ion-icon name="ticket" class="ml-2"></ion-icon>
            </h2>
            <a href="{{ route('tickets.index') }}" class="border border-black hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                <ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>
                Back to Tickets
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <input type="text" name="sender_id" value="{{ Auth::user()->id }}" hidden>

                            <div>
                                <label for="subject" class="block text-gray-700 font-semibold mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" required>
                                @error('subject')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
                                <div class="relative">
                                    <select id="ticketCategory" name="category" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" required>
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
                                </div>
                                @error('category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="content" class="block text-gray-700 font-semibold mb-2">Description</label>
                                <textarea id="content" name="content" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="attachments" class="block text-gray-700 font-semibold mb-2">Attachments (optional)</label>
                                <div class="flex items-center justify-center bg-gray-100 rounded-lg py-4">
                                    <label for="attachments" class="flex flex-col items-center justify-center cursor-pointer">
                                        <div class="flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full mb-2 transition-colors duration-200 hover:bg-blue-600">
                                            <ion-icon name="attach-outline" class="text-2xl"></ion-icon>
                                        </div>
                                        <span class="text-sm text-gray-700">Click to upload files</span>
                                    </label>
                                    <input type="file" id="attachments" name="attachments[]" class="hidden" multiple onchange="previewFiles(this.files)" accept="image/*">
                                    
                                </div>
                                <div id="filePreview" class="mt-4"></div>
                                @error('attachments')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Submit Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-users-layout>

<script>
    let selectedFiles = [];

    function previewFiles(files) {
    const filePreview = document.getElementById('filePreview');
    filePreview.innerHTML = '';

    selectedFiles = [...selectedFiles, ...files];

    if (selectedFiles.length === 0) {
        return;
    }

    selectedFiles.forEach((file) => {
        const reader = new FileReader();

        reader.addEventListener('load', () => {
            const imgPreview = document.createElement('div');
            imgPreview.classList.add('m-2', 'relative', 'inline-block');

            const img = document.createElement('img');
            img.src = reader.result;
            img.classList.add('max-h-32', 'object-contain', 'rounded-lg');

            const removeBtn = document.createElement('button');
            removeBtn.classList.add('transform', 'translate-x-2', '-translate-y-2', 'absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'w-6', 'h-6', 'flex', 'items-center', 'justify-center', 'focus:outline-none', 'hover:bg-red-600', 'transition-colors', 'duration-200');
            removeBtn.innerHTML = '&times;';
            removeBtn.addEventListener('click', () => {
                imgPreview.remove();
                selectedFiles = selectedFiles.filter(f => f !== file);
            });

            imgPreview.appendChild(img);
            imgPreview.appendChild(removeBtn);
            filePreview.appendChild(imgPreview);
        });

        reader.readAsDataURL(file);
    });
}

</script>