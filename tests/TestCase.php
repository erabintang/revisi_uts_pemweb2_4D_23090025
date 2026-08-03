<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Daftarkan koneksi sqlite in-memory KHUSUS untuk test otomatis (phpunit).
     *
     * Aplikasi produksi 100% SUPABASE — config/database.php hanya berisi
     * koneksi 'pgsql'. Harness di bawah murni untuk test: database
     * in-memory (tidak ada file, tidak persisten) supaya test berjalan
     * tanpa jaringan dan TIDAK PERNAH menyentuh data Supabase.
     */
    protected function refreshApplication(): void
    {
        parent::refreshApplication();

        config([
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);
    }
}
