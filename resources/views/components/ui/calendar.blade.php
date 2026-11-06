@props([
    'name' => 'date',
    'value' => null,
    'minDate' => null,
    'maxDate' => null,
])

<x-ui.date-picker :name="$name" :value="$value" :minDate="$minDate" :maxDate="$maxDate" {{ $attributes }} />

