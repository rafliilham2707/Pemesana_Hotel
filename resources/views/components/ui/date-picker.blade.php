@props([
    'name' => 'date',
    'value' => null,
    'minDate' => null,
    'maxDate' => null,
    'placeholder' => 'Pilih tanggal',
    'label' => null,
])

@php
$initialValue = $value ?? date('Y-m-d');
@endphp

<div
    x-data="{
        open: false,
        selectedDate: '{{ $value }}',
        viewYear: {{ (int) date('Y', strtotime($initialValue)) }},
        viewMonth: {{ (int) date('n', strtotime($initialValue)) - 1 }},
        minDate: '{{ $minDate }}',
        maxDate: '{{ $maxDate }}',
        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        dayNames: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],

        formatDisplay(dateStr) {
            if (!dateStr) return '{{ $placeholder }}';
            const [y, m, d] = dateStr.split('-').map(Number);
            const date = new Date(y, m - 1, d);
            const dayName = this.dayNames[date.getDay()];
            const monthName = this.monthNames[date.getMonth()];
            return `${dayName}, ${d} ${monthName.substring(0, 3)} ${y}`;
        },

        get daysInMonth() {
            return new Date(this.viewYear, this.viewMonth + 1, 0).getDate();
        },

        get firstDayOfWeek() {
            return new Date(this.viewYear, this.viewMonth, 1).getDay();
        },

        prevMonth() {
            if (this.viewMonth === 0) {
                this.viewMonth = 11;
                this.viewYear--;
            } else {
                this.viewMonth--;
            }
        },

        nextMonth() {
            if (this.viewMonth === 11) {
                this.viewMonth = 0;
                this.viewYear++;
            } else {
                this.viewMonth++;
            }
        },

        isSelected(day) {
            const dateStr = this.toDateString(day);
            return this.selectedDate === dateStr;
        },

        isToday(day) {
            const today = new Date();
            return today.getFullYear() === this.viewYear &&
                   today.getMonth() === this.viewMonth &&
                   today.getDate() === day;
        },

        isDisabled(day) {
            const dateStr = this.toDateString(day);
            if (this.minDate && dateStr < this.minDate) return true;
            if (this.maxDate && dateStr > this.maxDate) return true;
            return false;
        },

        toDateString(day) {
            const m = String(this.viewMonth + 1).padStart(2, '0');
            const d = String(day).padStart(2, '0');
            return `${this.viewYear}-${m}-${d}`;
        },

        selectDay(day) {
            if (this.isDisabled(day)) return;
            this.selectedDate = this.toDateString(day);
            this.open = false;
            this.$dispatch('date-selected', { name: '{{ $name }}', date: this.selectedDate });
        }
    }"
    class="relative w-full"
    @click.outside="open = false"
>
    @if($label)
        <label class="text-xs font-semibold text-muted-foreground uppercase tracking-wider block mb-1">
            {{ $label }}
        </label>
    @endif

    {{-- Hidden Form Input --}}
    <input type="hidden" name="{{ $name }}" :value="selectedDate" {{ $attributes->except(['class', 'placeholder']) }}>

    {{-- Trigger Button --}}
    <button
        type="button"
        @click="open = !open"
        class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-accent/40 focus:outline-none focus:ring-1 focus:ring-ring text-left cursor-pointer"
    >
        <span class="flex items-center gap-2 truncate">
            <x-ui.icon name="calendar" class="w-4 h-4 text-primary shrink-0" />
            <span :class="selectedDate ? 'text-foreground font-medium' : 'text-muted-foreground'" x-text="formatDisplay(selectedDate)"></span>
        </span>
        <x-ui.icon name="chevron-down" class="w-4 h-4 text-muted-foreground shrink-0 transition-transform duration-200" ::class="open ? 'rotate-180' : ''" />
    </button>

    {{-- Popover Calendar --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute left-0 z-50 mt-2 w-72 rounded-lg border bg-popover p-3 text-popover-foreground shadow-lg focus:outline-none"
    >
        {{-- Header Navigation --}}
        <div class="flex items-center justify-between pb-2 mb-2 border-b">
            <button
                type="button"
                @click="prevMonth()"
                class="inline-flex h-7 w-7 items-center justify-center rounded-md text-muted-foreground hover:bg-accent hover:text-foreground cursor-pointer"
            >
                <x-ui.icon name="chevron-left" class="w-4 h-4" />
            </button>
            <span class="text-sm font-semibold" x-text="`${monthNames[viewMonth]} ${viewYear}`"></span>
            <button
                type="button"
                @click="nextMonth()"
                class="inline-flex h-7 w-7 items-center justify-center rounded-md text-muted-foreground hover:bg-accent hover:text-foreground cursor-pointer"
            >
                <x-ui.icon name="chevron-right" class="w-4 h-4" />
            </button>
        </div>

        {{-- Day names header --}}
        <div class="grid grid-cols-7 gap-1 text-center mb-1">
            <template x-for="name in dayNames" :key="name">
                <span class="text-[11px] font-medium text-muted-foreground py-1" x-text="name"></span>
            </template>
        </div>

        {{-- Days Grid --}}
        <div class="grid grid-cols-7 gap-1 text-center">
            {{-- Empty cells before first day --}}
            <template x-for="i in firstDayOfWeek" :key="'empty-' + i">
                <span class="h-8"></span>
            </template>

            {{-- Day buttons --}}
            <template x-for="day in daysInMonth" :key="day">
                <button
                    type="button"
                    @click="selectDay(day)"
                    :disabled="isDisabled(day)"
                    class="h-8 w-8 mx-auto flex items-center justify-center rounded-md text-xs font-medium transition-colors select-none"
                    :class="{
                        'bg-primary text-primary-foreground hover:bg-primary': isSelected(day),
                        'border border-primary text-primary font-semibold': isToday(day) && !isSelected(day),
                        'text-foreground hover:bg-accent hover:text-accent-foreground cursor-pointer': !isSelected(day) && !isDisabled(day),
                        'text-muted-foreground/30 opacity-40 cursor-not-allowed pointer-events-none line-through': isDisabled(day)
                    }"
                    x-text="day"
                ></button>
            </template>
        </div>
    </div>
</div>

