@props([
    'id' => null,
    'side' => 'right', // left, right, top, bottom
    'title' => null,
    'description' => null,
])

@php
$sheetId = $id ?? 'sheet-' . uniqid();

$sideClasses = match($side) {
    'left' => 'inset-y-0 left-0 h-full w-3/4 max-w-sm border-r',
    'right' => 'inset-y-0 right-0 h-full w-3/4 max-w-sm border-l',
    'top' => 'inset-x-0 top-0 border-b',
    'bottom' => 'inset-x-0 bottom-0 border-t',
    default => 'inset-y-0 right-0 h-full w-3/4 max-w-sm border-l',
};

$enterStart = match($side) {
    'left' => '-translate-x-full',
    'right' => 'translate-x-full',
    'top' => '-translate-y-full',
    'bottom' => 'translate-y-full',
    default => 'translate-x-full',
};
@endphp

<div
    x-data="{ open: false }"
    @open-sheet.window="if ($event.detail === '{{ $sheetId }}' || $event.detail?.id === '{{ $sheetId }}') open = true"
    @close-sheet.window="if ($event.detail === '{{ $sheetId }}' || $event.detail?.id === '{{ $sheetId }}' || !$event.detail) open = false"
    @keydown.escape.window="open = false"
    class="relative inline-block"
>
    {{-- Trigger --}}
    @if(isset($trigger))
        <div @click="open = true" class="cursor-pointer inline-block">
            {{ $trigger }}
        </div>
    @endif

    {{-- Sheet Backdrop and Drawer --}}
    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 overflow-hidden"
            role="dialog"
            aria-modal="true"
        >
            {{-- Backdrop --}}
            <div
                x-show="open"
                x-transition:enter="ease-in-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="open = false"
                class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity"
            ></div>

            {{-- Drawer Panel --}}
            <div
                x-show="open"
                x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="{{ $enterStart }}"
                x-transition:enter-end="translate-x-0 translate-y-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0 translate-y-0"
                x-transition:leave-end="{{ $enterStart }}"
                class="fixed z-50 flex flex-col bg-background p-6 shadow-xl transition ease-in-out {{ $sideClasses }}"
            >
                {{-- Close Button --}}
                <button
                    type="button"
                    @click="open = false"
                    class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 cursor-pointer text-muted-foreground hover:text-foreground"
                >
                    <x-ui.icon name="x" class="w-4 h-4" />
                    <span class="sr-only">Tutup</span>
                </button>

                {{-- Header --}}
                @if($title || $description)
                    <div class="flex flex-col space-y-2 text-left mb-6">
                        @if($title)
                            <h3 class="text-lg font-semibold text-foreground">{{ $title }}</h3>
                        @endif
                        @if($description)
                            <p class="text-sm text-muted-foreground">{{ $description }}</p>
                        @endif
                    </div>
                @endif

                {{-- Content --}}
                <div class="flex-1 overflow-y-auto pr-1">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                @if(isset($footer))
                    <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2 pt-4 border-t">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </template>
</div>

