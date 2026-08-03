<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <style>[x-cloak]{display:none !important}</style>
    </head>
    <body class="relative min-h-svh bg-slate-100 font-sans antialiased">
        {{-- Dekorasi background (light & ringan) --}}
        <div class="pointer-events-none fixed inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-indigo-200/60 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-sky-200/60 blur-3xl"></div>
            <div class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-fuchsia-100/50 blur-3xl"></div>
        </div>

        <div class="relative flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-3 font-medium" wire:navigate>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-600 shadow-lg shadow-indigo-200 transition hover:bg-indigo-500">
                        <x-app-logo-icon class="size-7 fill-current text-white" />
                    </span>
                    <span class="text-lg font-semibold tracking-tight text-slate-800">
                        {{ config('app.name', 'Laravel') }}
                    </span>
                </a>

                <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/60">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
