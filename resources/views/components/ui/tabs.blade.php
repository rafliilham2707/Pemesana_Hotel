@props([
    'default' => null,
])

<div x-data="{ activeTab: '{{ $default }}' }" {{ $attributes->merge(['class' => 'w-full']) }}>
    {{ $slot }}
</div>

