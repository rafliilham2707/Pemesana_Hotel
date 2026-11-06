@props([
    'name' => null,
    'value' => '1',
    'checked' => false,
    'label' => null,
    'description' => null,
    'id' => null,
])

@php
$checkboxId = $id ?? ($name ? $name . '-' . uniqid() : 'checkbox-' . uniqid());
@endphp

<div class="flex items-start space-x-2">
    <div class="relative flex items-center justify-center pt-0.5">
        <input
            type="checkbox"
            id="{{ $checkboxId }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @checked($checked)
            {{ $attributes->merge(['class' => 'peer h-4 w-4 shrink-0 rounded-xs border border-primary shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 accent-primary cursor-pointer']) }}
        />
    </div>

    @if($label || $description || !$slot->isEmpty())
        <div class="grid gap-1 leading-none select-none">
            @if($label)
                <label for="{{ $checkboxId }}" class="text-sm font-medium leading-none cursor-pointer peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                    {{ $label }}
                </label>
            @endif
            @if($description)
                <p class="text-xs text-muted-foreground">{{ $description }}</p>
            @endif
            {{ $slot }}
        </div>
    @endif
</div>

