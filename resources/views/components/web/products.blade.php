@extends('layouts.app')

@section('content')
    @include('components.navbar') <!-- Pastikan navbar disertakan -->
    <div class="container">
        <h1>{{ $title }}</h1>
        <!-- Konten halaman produk -->
    </div>
@endsection