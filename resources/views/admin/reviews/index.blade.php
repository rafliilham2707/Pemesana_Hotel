<x-layouts.admin :title="'Moderasi Ulasan Tamu'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Moderasi Ulasan Tamu</h1>
            <p class="text-xs text-muted-foreground">Kelola ulasan dan penilaian yang diberikan pelanggan untuk hotel</p>
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
                                <th class="py-3 px-4">Pengguna</th>
                                <th class="py-3 px-4">Hotel</th>
                                <th class="py-3 px-4">Rating</th>
                                <th class="py-3 px-4">Komentar / Ulasan</th>
                                <th class="py-3 px-4">Waktu</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($reviews as $r)
                                <tr class="hover:bg-muted/40 transition-colors">
                                    <td class="py-3 px-4">
                                        <p class="font-bold text-foreground">{{ $r->user->name }}</p>
                                        <p class="text-muted-foreground text-[11px]">{{ $r->user->email }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="font-medium text-foreground">{{ $r->hotel->name }}</p>
                                        <p class="text-muted-foreground text-[11px]">{{ $r->hotel->city->name }}</p>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-amber-500 whitespace-nowrap">
                                        ★ {{ $r->rating }} / 5
                                    </td>
                                    <td class="py-3 px-4 max-w-md">
                                        <p class="text-foreground line-clamp-2">"{{ $r->comment }}"</p>
                                    </td>
                                    <td class="py-3 px-4 text-muted-foreground whitespace-nowrap">
                                        {{ $r->created_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 text-right whitespace-nowrap">
                                        <form action="{{ route('admin.reviews.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-destructive hover:text-destructive/80" title="Hapus Ulasan">
                                                <x-ui.icon name="trash-2" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-muted-foreground">Belum ada ulasan dari pelanggan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-border">
                    {{ $reviews->links('components.ui.pagination') }}
                </div>
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layouts.admin>

