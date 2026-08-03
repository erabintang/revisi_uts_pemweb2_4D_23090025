# Run Doc — revisi_uts_pemweb2_4D_23090025 (mangkrak.io)

Laravel 12 + Livewire/Volt preview server.

## Reproduce the artifacts

This thread's workspace IS the main checkout (no separate worktree), so no env files
need copying — `.env`, `database/database.sqlite`, `vendor/`, and `node_modules/`
already exist locally. If starting from a fresh checkout, reproduce them with:

```bash
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
composer install
npm install
npm run build
```

Note: `.env` uses SQLite (`DB_CONNECTION=sqlite`). If `DB_DATABASE` is unset, Laravel
defaults to `database/database.sqlite` automatically.

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
