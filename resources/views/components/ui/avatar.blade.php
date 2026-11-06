@props([
    'src' => null,
    'alt' => '',
    'fallback' => 'U',
    'size' => 'default',
])

@php
$sizes = [
    'sm' => 'h-8 w-8 text-xs',
    'default' => 'h-10 w-10 text-sm',
    'lg' => 'h-14 w-14 text-base',
    'xl' => 'h-20 w-20 text-xl',
];

$sizeClass = $sizes[$size] ?? $sizes['default'];

// Compute initials if not provided
if ($fallback === 'U' && !empty($alt)) {
    $words = explode(' ', trim($alt));
    $initials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $initials .= mb_substr($w, 0, 1);
    }
    $fallback = strtoupper($initials) ?: 'U';
}
@endphp

<div
    x-data="{ imageFailed: false }"
    {{ $attributes->merge(['class' => 'relative flex shrink-0 overflow-hidden rounded-full bg-muted border border-border select-none ' . $sizeClass]) }}
>
    @if($src)
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            x-show="!imageFailed"
            x-on:error="imageFailed = true"
            class="aspect-square h-full w-full object-cover"
        />
        <div
            x-show="imageFailed"
            class="flex h-full w-full items-center justify-center rounded-full bg-secondary text-secondary-foreground font-semibold uppercase"
        >
            {{ $fallback }}
        </div>
    @else
        <div class="flex h-full w-full items-center justify-center rounded-full bg-secondary text-secondary-foreground font-semibold uppercase">
            {{ $fallback }}
        </div>
    @endif
</div>
