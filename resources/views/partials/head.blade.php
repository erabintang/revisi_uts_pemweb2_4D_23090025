<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ trim(($title ?? config('app.name')).' — mangkrak.io', ' — ') }}</title>

<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" />
<link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}" />

<meta name="description" content="mangkrak.io — toko online sederhana. Kelola produk dan kategori dengan mudah." />
<meta name="theme-color" content="#4f46e5" />

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
