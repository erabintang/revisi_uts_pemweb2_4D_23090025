# 🚀 Panduan Deploy ke Vercel — mangkrak.io (Laravel 12 + Supabase)

Panduan lengkap untuk men-deploy aplikasi ke Vercel. Ikuti urut dari awal.

---

## 0. Prasyarat

- ✅ Repo GitHub berisi proyek ini (sudah ada: `github.com/erabintang/revisi_uts_pemweb2_4D_23090025`)
- ✅ Akun di [vercel.com](https://vercel.com)
- ✅ Database **Supabase** sudah aktif, 16 tabel sudah dibuat (`database/supabase-schema.sql`), dan berisi data demo (2 user, 4 kategori, 8 produk)
- ✅ Koneksi Supabase sudah diverifikasi lokal (pooler `aws-1-ap-northeast-2.pooler.supabase.com:5432`)

> ⚠️ **Vercel punya filesystem read-only** — tidak bisa pakai SQLite. Proyek ini sudah 100% Supabase (PostgreSQL) sehingga aman.

---

## 1. Commit semua perubahan dulu (wajib!)

Sebelum deploy, semua perubahan berikut HARUS ikut ter-commit — kalau kurang, aplikasi akan error 500 di produksi:

```bash
git add -A
git commit -m "Siap deploy Vercel: Supabase-only + keamanan env"
git push origin main
```

**File penting yang wajib ikut:**
- `bootstrap/app.php` (berisi `dontMergeFrameworkConfiguration()`)
- Semua file `config/*.php` — **termasuk** `config/view.php`, `config/broadcasting.php`, `config/concurrency.php`, `config/cors.php`, `config/hashing.php` (file baru — tanpa ini halaman 500!)
- `config/database.php` (hanya koneksi `pgsql`)
- `resources/css/flux.css` + `resources/css/app.css` (CSS Flux disalin agar vite build tidak butuh `vendor/`)
- `.gitignore`, `.env.example` (sudah diisi placeholder, bukan kredensial asli)
- `.freebuff/` **TIDAK** ikut (sudah di-untrack + di-ignore — berisi data chat lokal)

---

## 2. Import proyek di dashboard Vercel

1. Buka [vercel.com](https://vercel.com) → **Add New Project** → **Import** repo GitHub kamu
2. Di halaman konfigurasi, atur:
   - **Framework Preset** → pilih **`Other`**
     - ⚠️ BUKAN Laravel, BUKAN Vite, BUKAN Next.js — Vercel tidak punya runtime PHP native. Runtime PHP kita di-handle oleh `vercel-php@0.9.0` lewat `vercel.json`.
     - "Vite" yang muncul di daftar itu hanya bundler aset frontend, bukan preset yang harus dipilih.
   - **Root Directory** → biarkan default (root proyek)
   - **Build Command** → **`composer run vercel`** (WAJIB!)
     - Ini yang menjalankan pipeline lengkap: `composer install` → `migrate`/`seed` → `view:cache` → `route:cache` → `npm install` → `vite build`.
     - ⚠️ Kalau dikosongkan, Vercel hanya menjalankan `npm run build` — dan gagal karena `vendor/` belum ada saat vite build.
     - 💡 Kalau muncul error `composer: command not found` saat build, biarkan Build Command kosong — vite build tetap sukses karena `flux.css` sudah disalin ke `resources/css/flux.css` (tidak butuh `vendor/`).
   - **Install Command** → default

---

## 3. Environment Variables (Settings → Environment Variables)

Klik **Environment Variables** dan isi satu per satu (nilai **asli** boleh di sini — ini tersimpan aman di Vercel, tidak masuk kode):

| Variable | Nilai |
|---|---|
| `APP_NAME` | `mangkrak.io` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | hasil dari: `php artisan key:generate --show` (di terminal lokal) |
| `APP_URL` | `https://<nama-proyek-mu>.vercel.app` |
| `SESSION_DRIVER` | `cookie` |
| `SESSION_LIFETIME` | `120` |
| `CACHE_STORE` | `array` |
| `QUEUE_CONNECTION` | `sync` |
| `LOG_CHANNEL` | `stderr` |
| `LOG_LEVEL` | `warning` |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | `aws-1-ap-northeast-2.pooler.supabase.com` |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | `postgres` |
| `DB_USERNAME` | `postgres.dutzawrbxrafzloftuhr` |
| `DB_PASSWORD` | **password database Supabase** (tombol Reveal di dashboard Supabase → Project Settings → Database → Connection string) |
| `DB_SSLMODE` | `require` |
| `PUBLIC_SUPABASE_URL` | `https://dutzawrbxrafzloftuhr.supabase.co` |
| `PUBLIC_SUPABASE_PUBLISHABLE_KEY` | `sb_publishable_...` (copy dari `.env` lokal kamu) |
| `MAIL_MAILER` | `log` |
| `FILESYSTEM_DISK` | `local` |

> 💡 **Cara mudah**: salin isi `.env` lokal kamu (yang sudah berisi nilai asli & berfungsi), lalu tempel nilainya ke Environment Variables Vercel. `APP_URL` saja yang disesuaikan dengan domain Vercel.

---

## 4. Deploy

1. Klik **Deploy** → tunggu build selesai (biasanya 2–5 menit)
2. Di tab **Build Logs**, pastikan semua langkah sukses:
   - `Installing dependencies` ✅
   - (kalau `APP_KEY` belum di-set) `Generated .env with APP_KEY` ✅
   - `migrate` / `db:seed` — boleh sukses atau `|| true` (tabel sudah ada di Supabase) ✅
   - `view:cache` & `route:cache` ✅
   - `npm run build` ✅
3. Status berubah menjadi **Ready** → klik domain `*.vercel.app`

> **Cara alternatif via CLI:**
> ```bash
> npm i -g vercel
> vercel login
> vercel --prod
> ```

---

## 5. Verifikasi setelah live

- [ ] `https://<domain>/up` → **200**
- [ ] Halaman `/` → menampilkan 4 kategori dari Supabase
- [ ] `/products` → menampilkan 8 produk dari Supabase
- [ ] Login admin di `/adminlogin` (`admin123` / `123456`) → masuk dashboard, menu CRUD tampil
- [ ] Login user di `/login` (`user123` / `123456`) → dashboard user tanpa menu CRUD
- [ ] Tambah/edit/hapus produk → **tersimpan di Supabase** (cek di dashboard Supabase → Table Editor → `products`)

---

## 6. Update kode berikutnya

Cukup `git add -A && git commit && git push origin main` → Vercel otomatis redeploy.

---

## 7. Troubleshooting

| Gejala | Penyebab & Solusi |
|---|---|
| Build gagal di "Installing dependencies" | Pastikan `composer.json` valid dan `composer.lock` ikut ter-commit |
| Build gagal `Can't resolve '../../vendor/livewire/flux/dist/flux.css'` | `vendor/` belum ada saat vite build. Sudah diperbaiki: flux.css disalin ke `resources/css/flux.css` (commit wajib) + set Build Command `composer run vercel` |
| Build gagal `composer: command not found` | Build Command tidak bisa pakai composer. Biarkan Build Command kosong — vite build tetap sukses karena flux.css sudah ter-commit |
| Halaman error **500 "could not find driver"** | `pdo_pgsql` TIDAK perlu diinstall — sudah ada di `vercel-php@0.9.0`. Cek ulang versi runtime di `vercel.json` (`vercel-php@0.9.0`) |
| Halaman error **500 "view.compiled kosong"** | `config/view.php` tidak ter-commit — pastikan semua file `config/*.php` ikut git |
| Login/CRUD tidak tersimpan | `DB_PASSWORD` salah/kosong, atau **Connection pooling** belum diaktifkan di Supabase (Project Settings → Database → Connection pooling) |
| `FATAL: tenant or user not found` | Region pooler salah atau pooling nonaktif. Host yang benar untuk proyek ini: `aws-1-ap-northeast-2.pooler.supabase.com` |
| Session login hilang setelah redeploy | `APP_KEY` tidak konsisten — set `APP_KEY` permanen di Environment Variables Vercel (jangan biarkan di-generate otomatis tiap build) |

---

## 8. Catatan keamanan

- 🔒 **JANGAN** menulis password database asli di file yang ter-commit (`.env.example`, `DEPLOY.md`, README) — file-file ini ikut ke GitHub. Kredensial asli hanya di `.env` lokal (ter-ignore) dan Environment Variables Vercel.
- 🔑 Password Supabase sempat pernah terekspos (chat/commit lama) — **disarankan reset**: Supabase → Project Settings → Database → **Reset database password** → lalu update `DB_PASSWORD` di Vercel & `.env`.
- 🧹 Jika repo publik, pertimbangkan menghapus `.freebuff/` dari riwayat git (sudah di-untrack; riwayat lama tetap ada sampai di-rewrite).
