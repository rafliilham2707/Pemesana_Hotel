@props([
    'error' => false,
    'rows' => 3,
])

@php
$baseClasses = 'flex w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 disabled:cursor-not-allowed disabled:opacity-50';
$stateClasses = $error
    ? 'border-destructive text-destructive focus-visible:ring-destructive'
    : 'border-input focus-visible:ring-ring';
$classes = $baseClasses . ' ' . $stateClasses;
@endphp

<textarea rows="{{ $rows }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</textarea>

