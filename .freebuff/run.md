# Run Doc — revisi_uts_pemweb2_4D_23090025 (mangkrak.io)

Laravel 12 + Livewire/Volt preview server (MySQL).

## Reproduce the artifacts

This thread's workspace IS the main checkout (no separate worktree), so no env files
need copying — `.env`, `vendor/`, and `node_modules/` already exist locally.
If starting from a fresh checkout, reproduce them with:

```bash
cp .env.example .env
php artisan key:generate
composer install
npm install
npm run build
```

Database is **MySQL** (`.env` uses `DB_CONNECTION=mysql`, DB `mangkrak_uts`,
host `127.0.0.1:3306`, user `root` / empty password — XAMPP default).
If MySQL is unavailable, switch to SQLite in `.env` and `touch database/database.sqlite`.

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS mangkrak_uts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
php artisan migrate --force
php artisan db:seed --force
```

## Run the server

```bash
php artisan serve --port=8123 --host=127.0.0.1
```

Health check: `curl http://127.0.0.1:8123/up` should return 200.

Demo accounts (seeded):
- Admin: `/adminlogin` — `admin123` / `123456`
- User: `/login` — `user123` / `123456`

For detached preview runs, log to
`.freebuff/preview-*.log` and register the URL + PID with `register_preview`.
