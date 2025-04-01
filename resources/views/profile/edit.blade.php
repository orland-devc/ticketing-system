@section('title', 'Profile ')


@if (Auth::user()->role == "Administrator")
    <x-app-layout>
        @include('profile.edit-body')
    </x-app-layout>
@elseif (Auth::user()->role == "Student")
    <x-users-layout>
        @include('profile.edit-body')
    </x-users-layout>
@elseif (Auth::user()->role == "Office")
    <x-office-layout>
        @include('profile.edit-body')
    </x-office-layout>
@endif

