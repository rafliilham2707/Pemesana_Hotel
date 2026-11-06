@props([
    'error' => false,
])

@php
$baseClasses = 'flex h-9 w-full items-center justify-between rounded-md border bg-transparent px-3 py-1.5 text-sm shadow-sm transition-colors focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-50 appearance-none pr-8 cursor-pointer';
$stateClasses = $error
    ? 'border-destructive text-destructive focus:ring-destructive'
    : 'border-input focus:ring-ring';
$classes = $baseClasses . ' ' . $stateClasses;
@endphp

<div class="relative w-full">
    <select {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </select>
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-muted-foreground">
        <x-ui.icon name="chevron-down" class="w-4 h-4" />
    </div>
</div>

