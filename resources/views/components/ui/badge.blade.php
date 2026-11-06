@props([
    'variant' => 'default',
])

@php
$baseClasses = 'inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 select-none';

$variants = [
    'default' => 'border-transparent bg-primary text-primary-foreground shadow hover:bg-primary/80',
    'secondary' => 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80',
    'destructive' => 'border-transparent bg-destructive text-destructive-foreground shadow hover:bg-destructive/80',
    'outline' => 'text-foreground border-border',
    'success' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-400',
    'warning' => 'border-amber-200 bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:border-amber-800 dark:text-amber-400',
    'info' => 'border-sky-200 bg-sky-50 text-sky-700 dark:bg-sky-950/40 dark:border-sky-800 dark:text-sky-400',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>

