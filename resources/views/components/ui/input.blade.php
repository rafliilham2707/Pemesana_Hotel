@props([
    'type' => 'text',
    'error' => false,
])

@php
$baseClasses = 'flex h-9 w-full rounded-md border bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 disabled:cursor-not-allowed disabled:opacity-50';
$stateClasses = $error
    ? 'border-destructive text-destructive focus-visible:ring-destructive'
    : 'border-input focus-visible:ring-ring';
$classes = $baseClasses . ' ' . $stateClasses;
@endphp

<input type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>

