<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    
    <h3>Ini adalah halaman Homepage</h3>

    <div class="row">
        <h3>Categories</h3>
        @foreach($categories as $category)
        <div class="col-2 mb-3">
            <x-card 
                :image="$category['image']"
                :title="$category['name']"
                :description="$category['description']"
                :link="url('/category/' . $category['slug'])"
                :alt="$category['name']"
            />
        </div>
        @endforeach
    </div>

    {{-- Alert tampil di bawah card --}}
    <x-alert type="success" message="Data kategori berhasil dimuat!" />
</x-layout>
