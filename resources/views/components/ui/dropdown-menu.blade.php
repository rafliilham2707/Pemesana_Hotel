@props([
    'align' => 'right',
    'width' => 'w-56',
])

@php
$alignmentClasses = match ($align) {
    'left' => 'left-0 origin-top-left',
    'center' => 'left-1/2 -translate-x-1/2 origin-top',
    'right' => 'right-0 origin-top-right',
    default => 'right-0 origin-top-right',
};
@endphp

<div
    x-data="{ open: false }"
    @click.outside="open = false"
    @keydown.escape.window="open = false"
    class="relative inline-block text-left"
>
    {{-- Trigger --}}
    <div @click="open = !open" class="inline-flex cursor-pointer">
        {{ $trigger }}
    </div>

    {{-- Menu Content --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $width }} {{ $alignmentClasses }} rounded-md border bg-popover p-1 text-popover-foreground shadow-md focus:outline-none"
        @click="open = false"
    >
        {{ $slot }}
    </div>
</div>

