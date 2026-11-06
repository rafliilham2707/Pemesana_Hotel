<x-layouts.admin :title="'Kelola Voucher Promo'">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Kupon & Voucher Promo</h1>
                <p class="text-xs text-muted-foreground">Kelola kode diskon promosi untuk pelanggan StayHub</p>
            </div>
            <a href="{{ route('admin.vouchers.create') }}">
                <x-ui.button size="sm" class="gap-1.5">
                    <x-ui.icon name="plus" class="w-4 h-4" />
                    Tambah Voucher Baru
                </x-ui.button>
            </a>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success">{{ session('status') }}</x-ui.alert>
        @endif

        <x-ui.card>
            <x-ui.card.content class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="text-muted-foreground uppercase border-b border-border bg-muted/20">
                            <tr>
                                <th class="py-3 px-4">Kode Voucher</th>
                                <th class="py-3 px-4">Tipe & Nilai Diskon</th>
                                <th class="py-3 px-4">Min. Belanja</th>
                                <th class="py-3 px-4">Maks. Diskon</th>
                                <th class="py-3 px-4">Sisa Kuota</th>
                                <th class="py-3 px-4">Masa Berlaku</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($vouchers as $v)
                                <tr class="hover:bg-muted/40 transition-colors">
                                    <td class="py-3 px-4">
                                        <code class="font-bold text-sm font-mono text-primary px-2 py-0.5 bg-primary/10 rounded">{{ $v->code }}</code>
                                    </td>
                                    <td class="py-3 px-4 font-semibold">
                                        {{ $v->type->value === 'percent' ? $v->value . '%' : format_rupiah($v->value) }}
                                    </td>
                                    <td class="py-3 px-4 text-muted-foreground">
                                        {{ $v->min_spend ? format_rupiah($v->min_spend) : 'Tanpa minimum' }}
                                    </td>
                                    <td class="py-3 px-4 text-muted-foreground">
                                        {{ $v->max_discount ? format_rupiah($v->max_discount) : '-' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $v->quota !== null ? $v->quota . ' kali' : 'Unlimited' }}
                                    </td>
                                    <td class="py-3 px-4 text-muted-foreground">
                                        {{ \Carbon\Carbon::parse($v->valid_from)->format('d M') }} - {{ \Carbon\Carbon::parse($v->valid_until)->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <form action="{{ route('admin.vouchers.toggle-status', $v->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $v->is_active ? 'bg-emerald-500/10 text-emerald-600' : 'bg-muted text-muted-foreground' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $v->is_active ? 'bg-emerald-500' : 'bg-muted-foreground' }}"></span>
                                                {{ $v->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.vouchers.edit', $v->id) }}" class="p-1 text-primary hover:text-primary/80" title="Edit">
                                                <x-ui.icon name="edit" class="w-4 h-4" />
                                            </a>
                                            <form action="{{ route('admin.vouchers.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Hapus voucher ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-destructive hover:text-destructive/80" title="Hapus">
                                                    <x-ui.icon name="trash-2" class="w-4 h-4" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-muted-foreground">Belum ada kupon promo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-border">
                    {{ $vouchers->links('components.ui.pagination') }}
                </div>
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layouts.admin>

