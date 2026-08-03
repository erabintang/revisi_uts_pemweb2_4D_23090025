<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Greeting -->
        <div class="relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-6 dark:border-neutral-800 dark:bg-neutral-900">
            <div class="absolute -top-16 -end-16 h-48 w-48 rounded-full bg-indigo-600/10 blur-3xl"></div>
            <p class="text-sm font-semibold tracking-widest text-indigo-600 uppercase dark:text-indigo-400">
                {{ $isAdmin ? 'Admin Panel' : 'Halo, selamat datang 👋' }}
            </p>
            <h1 class="mt-1 text-2xl font-bold text-neutral-900 dark:text-white">
                {{ $isAdmin ? 'Kelola toko mangkrak.io' : 'Ini halaman utama kamu' }}
            </h1>
            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                @if ($isAdmin)
                    Kamu punya akses penuh untuk mengelola produk &amp; kategori.
                @else
                    Jelajahi produk-produk terbaru dari toko kami. Akses kelola hanya untuk admin.
                @endif
            </p>

            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('home') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    Lihat Toko
                </a>

                @if ($isAdmin)
                    <a href="{{ route('products.create') }}" class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-100 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        + Tambah Produk
                    </a>
                @endif
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid auto-rows-min gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Produk</p>
                    <span class="flex size-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
                        <flux:icon name="cube" class="size-5" />
                    </span>
                </div>
                <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-white">{{ number_format($stats['products']) }}</p>
                <p class="mt-1 text-xs text-neutral-400">produk terdaftar</p>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Kategori</p>
                    <span class="flex size-9 items-center justify-center rounded-lg bg-fuchsia-100 text-fuchsia-600 dark:bg-fuchsia-950 dark:text-fuchsia-400">
                        <flux:icon name="folder" class="size-5" />
                    </span>
                </div>
                <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-white">{{ number_format($stats['categories']) }}</p>
                <p class="mt-1 text-xs text-neutral-400">kategori aktif</p>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Pengguna</p>
                    <span class="flex size-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400">
                        <flux:icon name="users" class="size-5" />
                    </span>
                </div>
                <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-white">{{ number_format($stats['users']) }}</p>
                <p class="mt-1 text-xs text-neutral-400">akun terdaftar</p>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Stok Menipis</p>
                    <span class="flex size-9 items-center justify-center rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-950 dark:text-amber-400">
                        <flux:icon name="exclamation-triangle" class="size-5" />
                    </span>
                </div>
                <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-white">{{ number_format($stats['lowStock']) }}</p>
                <p class="mt-1 text-xs text-neutral-400">stok ≤ 5</p>
            </div>
        </div>

        <!-- Quick actions (admin) -->
        @if ($isAdmin)
            <div class="grid gap-4 sm:grid-cols-2">
                <a href="{{ route('categories.index') }}" class="group flex items-center gap-4 rounded-2xl border border-neutral-200 bg-white p-5 transition hover:border-indigo-400 hover:shadow-md dark:border-neutral-800 dark:bg-neutral-900 dark:hover:border-indigo-500">
                    <span class="flex size-12 items-center justify-center rounded-xl bg-fuchsia-100 text-fuchsia-600 dark:bg-fuchsia-950 dark:text-fuchsia-400">
                        <flux:icon name="folder" class="size-6" />
                    </span>
                    <div class="flex-1">
                        <p class="font-semibold text-neutral-900 dark:text-white">Kelola Kategori</p>
                        <p class="text-sm text-neutral-500">Tambah, ubah &amp; hapus kategori produk</p>
                    </div>
                    <flux:icon name="chevron-right" class="size-5 text-neutral-400 transition group-hover:translate-x-1 group-hover:text-indigo-500" />
                </a>

                <a href="{{ route('products.index') }}" class="group flex items-center gap-4 rounded-2xl border border-neutral-200 bg-white p-5 transition hover:border-indigo-400 hover:shadow-md dark:border-neutral-800 dark:bg-neutral-900 dark:hover:border-indigo-500">
                    <span class="flex size-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
                        <flux:icon name="cube" class="size-6" />
                    </span>
                    <div class="flex-1">
                        <p class="font-semibold text-neutral-900 dark:text-white">Kelola Produk</p>
                        <p class="text-sm text-neutral-500">Tambah, ubah &amp; hapus produk toko</p>
                    </div>
                    <flux:icon name="chevron-right" class="size-5 text-neutral-400 transition group-hover:translate-x-1 group-hover:text-indigo-500" />
                </a>
            </div>
        @endif

        <!-- Recent Products -->
        <div class="relative h-full flex-1 overflow-hidden rounded-2xl border border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-900">
            <div class="flex items-center justify-between border-b border-neutral-200 px-5 py-4 dark:border-neutral-800">
                <h2 class="font-semibold text-neutral-900 dark:text-white">Produk Terbaru</h2>
                <a href="{{ route('home') }}" class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-400">Lihat semua →</a>
            </div>

            <div class="divide-y divide-neutral-100 dark:divide-neutral-800">
                @forelse ($recentProducts as $product)
                    <div class="flex items-center gap-4 px-5 py-3">
                        <div class="flex size-11 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-neutral-100 dark:bg-neutral-800">
                            @if ($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="size-full object-cover" />
                            @else
                                <flux:icon name="cube" class="size-5 text-neutral-400" />
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-neutral-900 dark:text-white">{{ $product->name }}</p>
                            <p class="truncate text-xs text-neutral-500">{{ $product->category->name ?? 'Tanpa kategori' }} · stok {{ $product->stock }}</p>
                        </div>
                        <p class="text-sm font-semibold text-neutral-900 dark:text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                @empty
                    <div class="flex flex-col items-center gap-2 px-5 py-12 text-center">
                        <flux:icon name="cube" class="size-10 text-neutral-300 dark:text-neutral-700" />
                        <p class="text-sm text-neutral-500">Belum ada produk. {{ $isAdmin ? 'Silakan tambah produk pertama kamu.' : '' }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
