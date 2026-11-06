@props([
    'as' => 'button',
    'href' => null,
    'destructive' => false,
])

@php
$baseClasses = 'relative flex w-full cursor-pointer select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 text-left';
$colorClass = $destructive ? 'text-destructive hover:bg-destructive/10 hover:text-destructive' : '';
$classes = $baseClasses . ' ' . $colorClass;
@endphp

@if($as === 'a' || $href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

