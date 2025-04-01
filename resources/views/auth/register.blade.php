@section('title', 'PSU Sign up Request')

<x-guest-layout>
    @if($errors->get('student_id'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ $errors->first('student_id') }}', 
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 px-4 py-2 rounded'
                }
            });
        </script>
    @endif
    <form method="POST" action="{{ route('signup.request') }}">
        @csrf

        <!-- Student ID -->
        <div>
            <x-input-label for="student_id" :value="__('Student ID')" />
            <x-text-input id="student_id" class="block mt-1 w-full" type="text" name="student_id" :value="old('student_id')" required autofocus autocomplete="student_id" />
            <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Course/Degree -->
        <div class="mt-4">
            <x-input-label for="course" :value="__('Course/Degree')" />
            <x-text-input id="course" class="block mt-1 w-full" type="text" name="course" :value="old('course')" required />
            <x-input-error :messages="$errors->get('course')" class="mt-2" />
        </div>

        <!-- Year Level -->
        <div class="mt-4">
            <x-input-label for="year_level" :value="__('Year Level')" />
            <select id="year_level" name="year_level" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">Select Year Level</option>
                <option value="1" {{ old('year_level') == '1' ? 'selected' : '' }}>1st Year</option>
                <option value="2" {{ old('year_level') == '2' ? 'selected' : '' }}>2nd Year</option>
                <option value="3" {{ old('year_level') == '3' ? 'selected' : '' }}>3rd Year</option>
                <option value="4" {{ old('year_level') == '4' ? 'selected' : '' }}>4th Year</option>
                <option value="5" {{ old('year_level') == '5' ? 'selected' : '' }}>5th Year</option>
                <option value="6" {{ old('year_level') == '6' ? 'selected' : '' }}>Alumni</option>

            </select>
            <x-input-error :messages="$errors->get('year_level')" class="mt-2" />
        </div>

        <!-- Birthdate -->
        <div class="mt-4">
            <x-input-label for="birthdate" :value="__('Birthdate')" />
            <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate')" required />
            <x-input-error :messages="$errors->get('birthdate')" class="mt-2"/>
        </div>
        

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login.student') }}">
                {{ __('Already have an account?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Submit Request') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>