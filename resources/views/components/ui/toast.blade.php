<div
    x-data="{
        init() {
            @if(session('success'))
                this.$store.toasts.add({
                    title: 'Berhasil!',
                    description: '{{ addslashes(session('success')) }}',
                    variant: 'success'
                });
            @endif
            @if(session('error'))
                this.$store.toasts.add({
                    title: 'Terjadi Kesalahan',
                    description: '{{ addslashes(session('error')) }}',
                    variant: 'destructive'
                });
            @endif
            @if(session('status'))
                this.$store.toasts.add({
                    title: 'Informasi',
                    description: '{{ addslashes(session('status')) }}',
                    variant: 'default'
                });
            @endif
        }
    }"
    @toast.window="$store.toasts.add($event.detail)"
    class="fixed bottom-4 right-4 z-50 flex max-h-screen w-full max-w-md flex-col-reverse gap-2 p-4 pointer-events-none sm:bottom-0 sm:right-0 sm:flex-col"
>
    <template x-for="item in $store.toasts.items" :key="item.id">
        <div
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="pointer-events-auto relative flex w-full items-start justify-between space-x-4 overflow-hidden rounded-lg border p-4 pr-8 shadow-lg transition-all"
            :class="{
                'bg-background text-foreground border-border': item.variant === 'default',
                'bg-destructive text-destructive-foreground border-destructive': item.variant === 'destructive',
                'border-emerald-500 bg-emerald-50 text-emerald-950 dark:bg-emerald-950 dark:text-emerald-100': item.variant === 'success',
                'border-amber-500 bg-amber-50 text-amber-950 dark:bg-amber-950 dark:text-amber-100': item.variant === 'warning'
            }"
        >
            <div class="grid gap-1">
                <template x-if="item.title">
                    <h5 class="text-sm font-semibold" x-text="item.title"></h5>
                </template>
                <template x-if="item.description">
                    <div class="text-sm opacity-90" x-text="item.description"></div>
                </template>
            </div>

            <button
                type="button"
                @click="$store.toasts.remove(item.id)"
                class="absolute right-2 top-2 rounded-md p-1 opacity-70 transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 cursor-pointer"
            >
                <x-ui.icon name="x" class="w-4 h-4" />
            </button>
        </div>
    </template>
</div>

