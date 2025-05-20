@props(['image', 'title', 'description', 'link', 'alt' => ''])

<div class="card h-100">
    @if($image)
        <img src="{{ $image }}" class="card-img-top" alt="{{ $alt }}">
    @endif
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <p class="card-text">{{ $description }}</p>
        <a href="{{ $link }}" class="btn btn-primary">Lihat</a>
    </div>
</div>
