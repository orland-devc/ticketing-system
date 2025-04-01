@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-5 pt-1 bg-blue-500 border-b-4 border-indigo-900 font-bold leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-5 pt-1 border-b-2 border-transparent font-bold leading-5 text-white hover:bg-blue-700 hover:border-gray-900 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
