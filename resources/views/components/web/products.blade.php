<x-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="container py-5">
        <h1 class="text-center mb-2">Our Products</h1>
        <p class="text-center text-muted mb-5">Temukan produk terbaik dari mangkrak.io</p>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        @if($product->image)
                            <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <span class="text-muted">No Image</span>
                            </div>
                        @endif
                        <div class="card-body text-center">
                            <span class="badge bg-light text-dark mb-2">{{ $product->category->name ?? 'Umum' }}</span>
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
                            <p class="text-success fw-bold mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-muted small">Stok: {{ $product->stock }}</p>
                        </div>
                        <div class="card-footer bg-white border-0 text-center pb-3">
                            <a href="{{ url('/products') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
