@props([
    'id' => null,
    'title' => null,
    'description' => null,
    'maxWidth' => 'sm:max-w-lg',
])

@php
$dialogId = $id ?? 'dialog-' . uniqid();
@endphp

<div
    x-data="{ open: false }"
    @open-dialog.window="if ($event.detail === '{{ $dialogId }}' || $event.detail?.id === '{{ $dialogId }}') open = true"
    @close-dialog.window="if ($event.detail === '{{ $dialogId }}' || $event.detail?.id === '{{ $dialogId }}' || !$event.detail) open = false"
    @keydown.escape.window="open = false"
    class="relative inline-block"
>
    {{-- Trigger --}}
    @if(isset($trigger))
        <div @click="open = true" class="inline-block cursor-pointer">
            {{ $trigger }}
        </div>
    @endif

    {{-- Backdrop & Modal --}}
    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4 sm:p-6"
            role="dialog"
            aria-modal="true"
        >
            {{-- Backdrop --}}
            <div
                x-show="open"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="open = false"
                class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity"
            ></div>

            {{-- Dialog Content --}}
            <div
                x-show="open"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.stop
                class="relative w-full {{ $maxWidth }} rounded-lg border bg-background p-6 shadow-lg z-10 my-8"
            >
                {{-- Close Button --}}
                <button
                    type="button"
                    @click="open = false"
                    class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none cursor-pointer text-muted-foreground hover:text-foreground"
                >
                    <x-ui.icon name="x" class="w-4 h-4" />
                    <span class="sr-only">Tutup</span>
                </button>

                {{-- Header --}}
                @if($title || $description)
                    <div class="flex flex-col space-y-1.5 text-center sm:text-left mb-4">
                        @if($title)
                            <h2 class="text-lg font-semibold leading-none tracking-tight">{{ $title }}</h2>
                        @endif
                        @if($description)
                            <p class="text-sm text-muted-foreground">{{ $description }}</p>
                        @endif
                    </div>
                @endif

                {{-- Body --}}
                <div class="py-2">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                @if(isset($footer))
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2 pt-4 border-t mt-4 gap-2 sm:gap-0">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </template>
</div>

