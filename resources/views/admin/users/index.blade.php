<x-layouts.admin :title="'Kelola Pengguna'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Kelola Pengguna</h1>
            <p class="text-xs text-muted-foreground">Daftar pengguna terdaftar, role akun, dan aktivitas reservasi</p>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success">{{ session('status') }}</x-ui.alert>
        @endif
        @if(session('error'))
            <x-ui.alert variant="destructive">{{ session('error') }}</x-ui.alert>
        @endif

        {{-- Search & Filter --}}
        <x-ui.card>
            <x-ui.card.content class="p-4">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <x-ui.icon name="search" class="w-4 h-4 text-muted-foreground absolute left-3 top-1/2 -translate-y-1/2" />
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, nomor telepon..." class="w-full pl-9 h-9 text-xs rounded-md border border-input bg-background focus:outline-none focus:ring-1 focus:ring-ring">
                    </div>
                    <div class="w-full sm:w-48">
                        <select name="role" class="w-full h-9 text-xs rounded-md border border-input bg-background focus:outline-none focus:ring-1 focus:ring-ring" onchange="this.form.submit()">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <x-ui.button type="submit" size="sm" variant="secondary">Cari</x-ui.button>
                </form>
            </x-ui.card.content>
        </x-ui.card>

        {{-- Users Table --}}
        <x-ui.card>
            <x-ui.card.content class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="text-muted-foreground uppercase border-b border-border bg-muted/20">
                            <tr>
                                <th class="py-3 px-4">Pengguna</th>
                                <th class="py-3 px-4">Kontak</th>
                                <th class="py-3 px-4">Role</th>
                                <th class="py-3 px-4">Total Pesanan</th>
                                <th class="py-3 px-4">Terdaftar</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($users as $u)
                                <tr class="hover:bg-muted/40 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <x-ui.avatar :name="$u->name" size="sm" />
                                            <div>
                                                <p class="font-bold text-foreground text-sm">{{ $u->name }}</p>
                                                <p class="text-muted-foreground text-[11px]">{{ $u->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-muted-foreground">
                                        {{ $u->phone ?: '-' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <x-ui.badge :variant="$u->isAdmin() ? 'destructive' : 'secondary'">
                                            {{ $u->isAdmin() ? 'Admin' : 'User' }}
                                        </x-ui.badge>
                                    </td>
                                    <td class="py-3 px-4 font-semibold">
                                        {{ $u->bookings_count }} Pesanan
                                    </td>
                                    <td class="py-3 px-4 text-muted-foreground">
                                        {{ $u->created_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        @if($u->id !== auth()->id())
                                            <form action="{{ route('admin.users.toggle-role', $u->id) }}" method="POST" onsubmit="return confirm('Ubah role pengguna ini?')">
                                                @csrf
                                                <x-ui.button type="submit" variant="outline" size="sm" class="h-7 text-[11px] px-2">
                                                    Jadikan {{ $u->isAdmin() ? 'User' : 'Admin' }}
                                                </x-ui.button>
                                            </form>
                                        @else
                                            <span class="text-muted-foreground text-[11px] italic">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-muted-foreground">Pengguna tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-border">
                    {{ $users->links('components.ui.pagination') }}
                </div>
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layouts.admin>

