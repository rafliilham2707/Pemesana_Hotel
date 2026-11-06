@props([
    'align' => 'left',
    'width' => 'w-72',
])

@php
$alignmentClasses = match ($align) {
    'left' => 'left-0 origin-top-left',
    'center' => 'left-1/2 -translate-x-1/2 origin-top',
    'right' => 'right-0 origin-top-right',
    default => 'left-0 origin-top-left',
};
@endphp

<div
    x-data="{ open: false }"
    @click.outside="open = false"
    @keydown.escape.window="open = false"
    class="relative inline-block w-full"
>
    {{-- Trigger --}}
    <div @click="open = !open" class="cursor-pointer">
        {{ $trigger }}
    </div>

    {{-- Popover Content --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $width }} {{ $alignmentClasses }} rounded-md border bg-popover p-4 text-popover-foreground shadow-md outline-none"
    >
        {{ $slot }}
    </div>
</div>

