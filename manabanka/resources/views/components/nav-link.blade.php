@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium leading-5 text-revolut-purple bg-revolut-purple-50 focus:outline-none transition duration-200 ease-in-out'
            : 'inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium leading-5 text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none transition duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a> 