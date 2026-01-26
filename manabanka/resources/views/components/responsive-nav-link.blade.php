@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-4 pr-4 py-3 rounded-lg text-left text-base font-medium text-revolut-purple bg-revolut-purple-50 focus:outline-none transition duration-200 ease-in-out'
            : 'block w-full pl-4 pr-4 py-3 rounded-lg text-left text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none transition duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a> 