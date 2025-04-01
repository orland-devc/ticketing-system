@props(['active'])

@php
$classes = ($active ?? false)
    ? 'relative flex items-center rounded-md h-12 px-4 border-l-4 text-white bg-blue-900 transition-colors duration-150 ease-in-out'
    : 'relative flex items-center rounded-md h-12 px-4 text-white border-l-4 border-transparent hover:bg-gray-700 transition-colors duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
