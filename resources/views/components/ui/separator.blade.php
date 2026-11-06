@props([
    'orientation' => 'horizontal',
])

@php
$classes = $orientation === 'vertical'
    ? 'h-full w-[1px] bg-border shrink-0'
    : 'h-[1px] w-full bg-border shrink-0';
@endphp

<div
    role="separator"
    aria-orientation="{{ $orientation }}"
    {{ $attributes->merge(['class' => $classes]) }}
></div>

