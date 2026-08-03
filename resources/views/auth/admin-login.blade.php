<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ __('Admin Login') }} — mangkrak.io</title>

        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" />
        <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}" />

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-neutral-950">
        <div class="relative grid min-h-svh items-center justify-center px-6 py-10 lg:grid-cols-2 lg:px-0">
            <!-- Branding panel -->
            <div class="relative hidden h-full flex-col justify-between overflow-hidden p-12 text-white lg:flex">
                <div class="absolute inset-0 bg-gradient-to-br from-neutral-900 via-neutral-900 to-indigo-950"></div>
                <div class="absolute -top-24 -end-24 h-96 w-96 rounded-full bg-indigo-600/30 blur-3xl"></div>
                <div class="absolute -bottom-32 -start-16 h-96 w-96 rounded-full bg-fuchsia-600/20 blur-3xl"></div>

                <a href="{{ route('home') }}" class="relative z-10 flex items-center gap-3 text-lg font-semibold">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/20 backdrop-blur">
                        <x-app-logo-icon class="h-6 fill-current text-white" />
                    </span>
                    mangkrak.io
                </a>

                <div class="relative z-10">
                    <p class="text-sm font-medium tracking-widest text-indigo-300 uppercase">Admin Panel</p>
                    <h1 class="mt-3 text-4xl font-bold leading-tight">Kelola toko kamu<br>dari satu tempat.</h1>
                    <p class="mt-4 max-w-md text-neutral-300">
                        Dashboard admin untuk mengelola produk, kategori, dan data toko mangkrak.io dengan cepat dan mudah.
                    </p>
                </div>

                <div class="relative z-10 flex items-center gap-2 text-xs text-neutral-400">
                    <span class="inline-block size-2 rounded-full bg-emerald-400"></span>
                    Sistem online &amp; aman
                </div>
            </div>

            <!-- Form panel -->
            <div class="w-full max-w-md">
                <div class="flex flex-col gap-6">
                    <a href="{{ route('home') }}" class="flex flex-col items-center gap-3 lg:hidden" wire:navigate>
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-900 text-white shadow-lg">
                            <x-app-logo-icon class="size-7 fill-current" />
                        </span>
                        <span class="text-lg font-semibold">mangkrak.io</span>
                    </a>

                    <div class="rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                        <div class="mb-6 text-center">
                            <p class="text-xs font-semibold tracking-widest text-indigo-500 uppercase">Admin Access</p>
                            <h2 class="mt-2 text-2xl font-bold text-neutral-900 dark:text-white">Login Admin</h2>
                            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Masuk menggunakan username &amp; password admin</p>
                        </div>

                        @if ($errors->any())
                            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-900 dark:bg-red-950/40 dark:text-red-300">
                                <ul class="list-disc space-y-1 ps-4">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login') }}" class="flex flex-col gap-5">
                            @csrf

                            <div class="grid gap-2">
                                <label for="name" class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Username</label>
                                <input
                                    id="name" name="name" type="text" value="{{ old('name') }}"
                                    autofocus autocomplete="username" required placeholder="admin123"
                                    class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-2.5 text-sm text-neutral-900 outline-none transition focus:ring-2 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white"
                                />
                            </div>

                            <div class="grid gap-2">
                                <label for="password" class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Password</label>
                                <input
                                    id="password" name="password" type="password"
                                    autocomplete="current-password" required placeholder="••••••"
                                    class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-2.5 text-sm text-neutral-900 outline-none transition focus:ring-2 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-950 dark:text-white"
                                />
                            </div>

                            <label class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                <input type="checkbox" name="remember" class="size-4 rounded border-neutral-300 text-indigo-600 focus:ring-indigo-500" />
                                Ingat saya
                            </label>

                            <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500 active:scale-[0.99]">
                                Masuk ke Dashboard
                            </button>
                        </form>

                        <div class="mt-6 rounded-xl bg-neutral-50 p-3 text-center text-xs text-neutral-500 dark:bg-neutral-950 dark:text-neutral-400">
                            Demo: <code class="font-semibold text-neutral-700 dark:text-neutral-300">admin123</code> / <code class="font-semibold text-neutral-700 dark:text-neutral-300">123456</code>
                        </div>
                    </div>

                    <p class="text-center text-sm text-neutral-500 dark:text-neutral-400">
                        Bukan admin?
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:underline dark:text-indigo-400">Login sebagai user</a>
                    </p>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
