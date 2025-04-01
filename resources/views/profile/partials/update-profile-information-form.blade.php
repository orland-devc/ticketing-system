<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Profile Picture')" />
            <div class="mb-10">
                <div class="">
                    <div class="relative group">
                        <!-- Profile Picture Preview -->
                        <img 
                            id="profile-pic-preview" 
                            src="{{ asset($user->profile_picture) }}" 
                            alt="Profile Picture" 
                            class="w-40 h-40 rounded-full object-cover border-4 border-indigo-200 shadow-lg transition-all duration-300 group-hover:border-indigo-400"
                        >
                        
                        <!-- Overlay with Camera Icon -->
                        <div class="absolute left-0 top-0 bottom-0 w-40 h-40 bg-black bg-opacity-50 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <label for="profile-picture-input" class="cursor-pointer p-4" aria-label="Change Profile Picture">
                                <!-- Camera Icon -->
                                <ion-icon name="camera" class="w-8 h-8" aria-hidden="true"></ion-icon>
                                <!-- File Input (Hidden) -->
                                <input 
                                    type="file" 
                                    id="profile-picture-input" 
                                    name="profile_picture" 
                                    class="hidden" 
                                    onchange="previewProfilePicture(event)" 
                                    accept="image/*"
                                >
                            </label>
                        </div>
                    </div>
                    
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
<script>
    function previewProfilePicture(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-pic-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>