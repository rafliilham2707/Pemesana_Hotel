@props([
    'variant' => 'default',
    'title' => null,
    'icon' => null,
])

@php
$baseClasses = 'relative w-full rounded-lg border p-4 [&>svg~*]:pl-7 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4';

$variants = [
    'default' => 'bg-background text-foreground border-border [&>svg]:text-foreground',
    'destructive' => 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive bg-destructive/5',
    'warning' => 'border-amber-500/40 text-amber-800 bg-amber-50 dark:border-amber-500/30 dark:bg-amber-950/20 dark:text-amber-300 [&>svg]:text-amber-600',
    'success' => 'border-emerald-500/40 text-emerald-800 bg-emerald-50 dark:border-emerald-500/30 dark:bg-emerald-950/20 dark:text-emerald-300 [&>svg]:text-emerald-600',
    'info' => 'border-sky-500/40 text-sky-800 bg-sky-50 dark:border-sky-500/30 dark:bg-sky-950/20 dark:text-sky-300 [&>svg]:text-sky-600',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']);

$defaultIcon = match ($variant) {
    'destructive' => 'alert-circle',
    'warning' => 'alert-triangle',
    'success' => 'check-circle-2',
    'info' => 'info',
    default => 'info',
};
$iconName = $icon ?? $defaultIcon;
@endphp

<div role="alert" {{ $attributes->merge(['class' => $classes]) }}>
    <x-ui.icon :name="$iconName" class="w-4 h-4 shrink-0" />
    <div class="space-y-1">
        @if($title)
            <h5 class="font-medium leading-none tracking-tight">{{ $title }}</h5>
        @endif
        <div class="text-sm opacity-90 leading-relaxed">
            {{ $slot }}
        </div>
    </div>
</div>

