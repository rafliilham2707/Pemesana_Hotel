@props([
    'title' => null,
    'description' => null,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-xl border bg-card text-card-foreground shadow']) }}>
    @if($title || $description)
        <div class="flex flex-col space-y-1.5 p-6">
            @if($title)
                <h3 class="font-semibold leading-none tracking-tight text-lg">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="text-sm text-muted-foreground">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="{{ ($title || $description) ? 'p-6 pt-0' : 'p-6' }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="flex items-center p-6 pt-0 border-t mt-4">
            {{ $footer }}
        </div>
    @endif
</div>

