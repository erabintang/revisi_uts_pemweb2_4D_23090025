<?php

// ─────────────────────────────────────────────────────────────────────
// COMPILED VIEW PATH — HARDENING UNTUK VERCEL (filesystem read-only)
//
// Di Vercel (serverless function), storage/framework/views TIDAK writable.
// Jika folder compiled default tidak bisa ditulis, otomatis pindah ke
// folder temp sistem (sys_get_temp_dir() → /tmp) yang selalu writable.
// Ini membuat app TIDAK bergantung pada env var VIEW_COMPILED_PATH lagi.
// ─────────────────────────────────────────────────────────────────────

$compiledViewPath = env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views')));

if ($compiledViewPath === false || ! is_writable($compiledViewPath)) {
    $compiledViewPath = sys_get_temp_dir().'/mangkrak-compiled-views';

    if (! is_dir($compiledViewPath)) {
        @mkdir($compiledViewPath, 0777, true);
    }
}

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => $compiledViewPath,

];
