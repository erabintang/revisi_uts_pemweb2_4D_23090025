# 🛒 mangkrak.io — Toko Online Sederhana

Aplikasi toko online (e-commerce) sederhana berbasis **Laravel 12 + Livewire + Flux**, dengan sistem **role Admin & User**, CRUD produk & kategori, dan siap deploy ke **Vercel**.

## ✨ Fitur

- **Login Admin** di `/adminlogin` (khusus role admin, dengan tampilan branding mangkrak.io)
- **Login User** di `/login` (bisa pakai **username** atau email)
- **Role system**: admin bisa akses penuh (dashboard + CRUD), user hanya melihat dashboard & toko
- **CRUD Kategori & Produk** lengkap (tambah, edit, hapus, cari, paginasi)
- Dashboard interaktif: statistik produk, kategori, pengguna, stok menipis, & produk terbaru
- Branding **mangkrak.io** di logo, favicon, dan judul halaman
- UI modern dengan Tailwind CSS 4 + Flux UI (dark mode)

## 🔑 Akun Demo

| Role  | Username   | Password |
|-------|------------|----------|
| Admin | `admin123` | `123456` |
| User  | `user123`  | `123456` |

- Admin login: <http://localhost:8000/adminlogin>
- User login: <http://localhost:8000/login>

## 🚀 Menjalankan Lokal

```bash
# 1. Install dependency PHP
composer install

# 2. Siapkan .env (SUPABASE-ONLY)
cp .env.example .env
php artisan key:generate

# 3. Buat tabel di Supabase (opsional, jika belum ada):
#    Buka dashboard Supabase → SQL Editor → paste isi database/supabase-schema.sql → RUN

# 4. Isi kredensial Supabase di .env — PENTING:
#    Project Settings → Database → Connection string (bagian POOLER)
#    - DB_HOST = <region>.pooler.supabase.com (mis. aws-1-ap-northeast-2.pooler.supabase.com)
#    - DB_USERNAME = postgres.<REF_PROJECT>
#    - DB_PASSWORD = PASSWORD DATABASE (BUKAN publishable key!)
#    - DB_PORT = 6543

# 5. Migrasi & seed (dijalankan juga otomatis saat deploy Vercel)
php artisan migrate --force
php artisan db:seed --force

# 6. Install & build aset frontend
npm install
npm run build

# 7. Jalankan server
php artisan serve
```

> ⚠️ **Proyek ini 100% memakai Supabase (PostgreSQL)** — tidak ada database lain.
> `PUBLIC_SUPABASE_URL` & `PUBLIC_SUPABASE_PUBLISHABLE_KEY` dipakai untuk klien
> Supabase (JS/HTTP). Untuk koneksi Laravel → database, wajib `DB_PASSWORD`
> (password database dari dashboard), **bukan** publishable key.
> File **`database/supabase-schema.sql`** berisi SQL lengkap untuk membuat semua tabel.

## ▲ Deploy ke Vercel

Proyek ini memakai runtime komunitas **`vercel-php`** (PHP 8.5) yang sudah dikonfigurasi di `vercel.json`.

### Cara 1 — Vercel CLI (disarankan)

```bash
# Install CLI
npm i -g vercel

# Login
vercel login

# Deploy (ikuti wizard)
vercel
```

### Cara 2 — Git Integration

1. Push repo ke GitHub
2. Di [vercel.com](https://vercel.com) → **Add New Project** → import repo
3. **Framework Preset**: pilih `Other`
4. Tambahkan environment variables di project settings (penting!):
   - `APP_KEY` → hasil dari `php artisan key:generate --show`
   - `APP_ENV` → `production`
   - `APP_DEBUG` → `false`
   - `APP_URL` → URL vercel kamu (contoh: `https://proyek-mu.vercel.app`)
   - `SESSION_DRIVER` → `cookie` (Vercel filesystem read-only, jangan pakai `database`)
   - `CACHE_STORE` → `array`
   - `QUEUE_CONNECTION` → `sync`
   - `DB_CONNECTION` → `pgsql` + `DB_HOST` (pooler, mis. `aws-1-ap-northeast-2.pooler.supabase.com`), `DB_PORT=5432`, `DB_DATABASE=postgres`, `DB_USERNAME=postgres.<REF>`, `DB_PASSWORD` (password database Supabase), `DB_SSLMODE=require`
   - `PUBLIC_SUPABASE_URL` & `PUBLIC_SUPABASE_PUBLISHABLE_KEY` (opsional, untuk klien JS)
5. Deploy 🎉

> ⚠️ **Penting**: Vercel punya filesystem read-only, jadi wajib pakai **Supabase (PostgreSQL)** agar login/CRUD tersimpan. Set `SESSION_DRIVER=cookie` dan `LOG_CHANNEL=stderr`.

> 🔧 **Catatan teknis**: `bootstrap/app.php` memanggil `dontMergeFrameworkConfiguration()` agar Laravel 12 tidak menyuntikkan koneksi DB default (sqlite/mysql/dll) ke config — sehingga hanya `pgsql` (Supabase) yang aktif. Karena itu seluruh file `config/*.php` (termasuk `view.php`, `broadcasting.php`, `concurrency.php`, `cors.php`, `hashing.php`) wajib ikut ter-commit. Saat upgrade Laravel, publikasikan ulang config framework yang baru: `php artisan config:publish` lalu sesuaikan.

### Struktur deploy

```
api/index.php      → bootstrap Laravel untuk runtime PHP Vercel
vercel.json        → konfigurasi runtime vercel-php & routing
composer vercel    → script build (migrate, seed, npm build) dijalankan otomatis saat deploy
```

## 📁 Struktur Utama

```
app/Http/Controllers/Auth/AdminLoginController.php   → login admin
app/Http/Middleware/EnsureUserRole.php               → middleware role
app/Models/User.php                                  → model user + isAdmin()/isUser()
database/seeders/DatabaseSeeder.php                  → akun demo + data contoh
resources/views/auth/admin-login.blade.php           → halaman /adminlogin
resources/views/dashboard.blade.php                  → dashboard role-aware
resources/views/dashboard/products|categories/       → CRUD views
```

## ✅ Test

```bash
php artisan test
```

---

Dibuat dengan ❤️ untuk tugas Pemrograman Web 2.
