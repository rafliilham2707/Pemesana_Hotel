@props([
    'required' => false,
])

<label {{ $attributes->merge(['class' => 'text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 select-none flex items-center gap-1']) }}>
    {{ $slot }}
    @if($required)
        <span class="text-destructive font-semibold">*</span>
    @endif
</label>

