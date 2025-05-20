<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <h3>Ini adalah halaman Single Category</h3>
    <h1>{{ $category['name'] }}</h1>
    <hr>
    <p>
        {{ $category['description'] }}
    </p>
</x-layout>