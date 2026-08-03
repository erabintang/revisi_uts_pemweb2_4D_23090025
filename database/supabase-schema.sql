-- ============================================================
-- mangkrak.io — Skema Database Supabase (PostgreSQL)
-- ------------------------------------------------------------
-- Cara pakai:
--   1. Buka dashboard Supabase → SQL Editor → New query
--   2. Paste seluruh isi file ini → RUN
--   3. Selesai, semua tabel + data demo terbuat.
--
-- Aman dijalankan ulang (DROP IF EXISTS di awal).
-- ============================================================

-- ---------- HAPUS TABEL LAMA (jika ada) ----------
DROP TABLE IF EXISTS migrations CASCADE;
DROP TABLE IF EXISTS order_details CASCADE;
DROP TABLE IF EXISTS orders CASCADE;
DROP TABLE IF EXISTS customers CASCADE;
DROP TABLE IF EXISTS products CASCADE;
DROP TABLE IF EXISTS post CASCADE;
DROP TABLE IF EXISTS product_categories CASCADE;
DROP TABLE IF EXISTS categories CASCADE;
DROP TABLE IF EXISTS failed_jobs CASCADE;
DROP TABLE IF EXISTS job_batches CASCADE;
DROP TABLE IF EXISTS jobs CASCADE;
DROP TABLE IF EXISTS cache_locks CASCADE;
DROP TABLE IF EXISTS cache CASCADE;
DROP TABLE IF EXISTS sessions CASCADE;
DROP TABLE IF EXISTS password_reset_tokens CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- ---------- USERS ----------
CREATE TABLE users (
    id                BIGSERIAL PRIMARY KEY,
    name              VARCHAR(255) NOT NULL,
    email             VARCHAR(255) NOT NULL UNIQUE,
    role              VARCHAR(20)  NOT NULL DEFAULT 'user',
    email_verified_at TIMESTAMP NULL,
    password          VARCHAR(255) NOT NULL,
    remember_token    VARCHAR(100) NULL,
    created_at        TIMESTAMP NULL,
    updated_at        TIMESTAMP NULL
);

-- ---------- PASSWORD RESET TOKENS ----------
CREATE TABLE password_reset_tokens (
    email      VARCHAR(255) PRIMARY KEY,
    token      VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

-- ---------- SESSIONS ----------
CREATE TABLE sessions (
    id            VARCHAR(255) PRIMARY KEY,
    user_id       BIGINT NULL,
    ip_address    VARCHAR(45) NULL,
    user_agent    TEXT NULL,
    payload       TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);
CREATE INDEX sessions_user_id_index ON sessions (user_id);
CREATE INDEX sessions_last_activity_index ON sessions (last_activity);

-- ---------- CACHE ----------
CREATE TABLE cache (
    key        VARCHAR(255) PRIMARY KEY,
    value      TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

-- ---------- CACHE LOCKS ----------
CREATE TABLE cache_locks (
    key        VARCHAR(255) PRIMARY KEY,
    owner      VARCHAR(255) NOT NULL,
    expiration INTEGER NOT NULL
);

-- ---------- JOBS ----------
CREATE TABLE jobs (
    id           BIGSERIAL PRIMARY KEY,
    queue        VARCHAR(255) NOT NULL,
    payload      TEXT NOT NULL,
    attempts     SMALLINT NOT NULL,
    reserved_at  INTEGER NULL,
    available_at INTEGER NOT NULL,
    created_at   INTEGER NOT NULL
);
CREATE INDEX jobs_queue_index ON jobs (queue);

-- ---------- JOB BATCHES ----------
CREATE TABLE job_batches (
    id             VARCHAR(255) PRIMARY KEY,
    name           VARCHAR(255) NOT NULL,
    total_jobs     INTEGER NOT NULL,
    pending_jobs   INTEGER NOT NULL,
    failed_jobs    INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options        TEXT NULL,
    cancelled_at   INTEGER NULL,
    created_at     INTEGER NOT NULL,
    finished_at    INTEGER NULL
);

-- ---------- FAILED JOBS ----------
CREATE TABLE failed_jobs (
    id         BIGSERIAL PRIMARY KEY,
    uuid       VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue      TEXT NOT NULL,
    payload    TEXT NOT NULL,
    exception  TEXT NOT NULL,
    failed_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ---------- CATEGORIES (tabel legacy, dipakai model Categories -> product_categories) ----------
CREATE TABLE categories (
    id         BIGSERIAL PRIMARY KEY,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- PRODUCT CATEGORIES ----------
CREATE TABLE product_categories (
    id          BIGSERIAL PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    slug        VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    image       VARCHAR(255) NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL
);

-- ---------- POST ----------
CREATE TABLE post (
    id         BIGSERIAL PRIMARY KEY,
    title      VARCHAR(255) NOT NULL,
    slug       VARCHAR(255) NOT NULL UNIQUE,
    body       TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- PRODUCTS ----------
CREATE TABLE products (
    id                  BIGSERIAL PRIMARY KEY,
    product_category_id BIGINT NULL,
    name                VARCHAR(255) NOT NULL,
    description         TEXT NULL,
    price               NUMERIC(10,2) NOT NULL,
    stock               INTEGER NOT NULL DEFAULT 0,
    image               VARCHAR(255) NULL,
    created_at          TIMESTAMP NULL,
    updated_at          TIMESTAMP NULL,
    CONSTRAINT products_product_category_id_fk FOREIGN KEY (product_category_id)
        REFERENCES product_categories (id) ON DELETE SET NULL
);

-- ---------- CUSTOMERS ----------
CREATE TABLE customers (
    id         BIGSERIAL PRIMARY KEY,
    name       VARCHAR(255) NOT NULL,
    email      VARCHAR(255) NOT NULL UNIQUE,
    address    TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- ORDERS ----------
CREATE TABLE orders (
    id           BIGSERIAL PRIMARY KEY,
    customer_id  BIGINT NOT NULL,
    order_date   DATE NULL,
    total_amount NUMERIC(10,2) NOT NULL DEFAULT 0.00,
    status       VARCHAR(20) NOT NULL DEFAULT 'pending'
                 CHECK (status IN ('pending','processing','completed','cancelled')),
    created_at   TIMESTAMP NULL,
    updated_at   TIMESTAMP NULL,
    CONSTRAINT orders_customer_id_fk FOREIGN KEY (customer_id)
        REFERENCES customers (id) ON DELETE CASCADE
);

-- ---------- MIGRATIONS (pelacakan migrasi Laravel) ----------
-- Wajib ada agar `php artisan migrate` (mis. saat deploy Vercel) tidak error
-- karena tabel sudah dibuat manual. Batch 1 = semua migrasi sudah dijalankan.
CREATE TABLE migrations (
    id        BIGSERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch     INTEGER NOT NULL
);

INSERT INTO migrations (migration, batch) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2025_04_09_032020_create_categories_table', 1),
('2025_04_16_092949_create_product_categories_table', 1),
('2025_04_16_095344_create_post_table', 1),
('2025_04_17_081025_create_products_table', 1),
('2025_05_12_055257_create_customers_table', 1),
('2025_05_12_055510_create_orders_table', 1),
('2025_05_12_055521_create_order_details_table', 1),
('2025_08_03_000000_add_role_to_users_table', 1);

-- ---------- ORDER DETAILS ----------
CREATE TABLE order_details (
    id          BIGSERIAL PRIMARY KEY,
    order_id    BIGINT NOT NULL,
    product_id  BIGINT NOT NULL,
    quantity    INTEGER NOT NULL DEFAULT 1,
    unit_price  NUMERIC(10,2) NOT NULL,
    subtotal    NUMERIC(10,2) NOT NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT order_details_order_id_fk FOREIGN KEY (order_id)
        REFERENCES orders (id) ON DELETE CASCADE,
    CONSTRAINT order_details_product_id_fk FOREIGN KEY (product_id)
        REFERENCES products (id) ON DELETE CASCADE
);

-- ============================================================
-- DATA DEMO
-- ============================================================

-- ---------- USERS DEMO ----------
-- Password untuk keduanya: 123456
INSERT INTO users (name, email, role, email_verified_at, password, created_at, updated_at) VALUES
('admin123', 'admin@mangkrak.io', 'admin', CURRENT_TIMESTAMP, '$2y$10$GfMTZpMbph6wTxdVutlDGuT97nyK8EF7PlVb5/uX.EU3GeVUqs.ey', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('user123',  'user@mangkrak.io',  'user',  CURRENT_TIMESTAMP, '$2y$10$GfMTZpMbph6wTxdVutlDGuT97nyK8EF7PlVb5/uX.EU3GeVUqs.ey', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- ---------- KATEGORI DEMO ----------
INSERT INTO product_categories (name, slug, description, image, created_at, updated_at) VALUES
('Elektronik', 'elektronik', 'Gadget dan perangkat elektronik', 'https://picsum.photos/seed/elektronik/200/200', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Fashion', 'fashion', 'Pakaian dan aksesoris gaya', 'https://picsum.photos/seed/fashion/200/200', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Makanan', 'makanan', 'Makanan dan minuman segar', 'https://picsum.photos/seed/makanan/200/200', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Rumah Tangga', 'rumah-tangga', 'Perlengkapan rumah tangga', 'https://picsum.photos/seed/rumah/200/200', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- ---------- PRODUK DEMO ----------
INSERT INTO products (product_category_id, name, description, price, stock, image, created_at, updated_at) VALUES
(1, 'Headphone Wireless Pro', 'Headphone bluetooth dengan noise cancelling', 899000, 25, 'https://picsum.photos/seed/headphone/400/400', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(1, 'Smartwatch Series 9', 'Jam tangan pintar dengan GPS dan monitor jantung', 2499000, 8, 'https://picsum.photos/seed/watch/400/400', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(2, 'Kaos Polos Premium', 'Kaos katun combed 24s, nyaman dipakai', 85000, 120, 'https://picsum.photos/seed/kaos/400/400', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(2, 'Jaket Hoodie Unisex', 'Hoodie fleece tebal untuk semua cuaca', 189000, 4, 'https://picsum.photos/seed/hoodie/400/400', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(3, 'Kopi Arabika Gayo 250g', 'Kopi bubuk arabika premium asal Gayo', 65000, 60, 'https://picsum.photos/seed/kopi/400/400', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(3, 'Sereal Granola 500g', 'Granola sehat dengan madu dan kacang', 78000, 15, 'https://picsum.photos/seed/granola/400/400', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(4, 'Set Panci Stainless', 'Panci premium anti lengket 5 pcs', 420000, 30, 'https://picsum.photos/seed/panci/400/400', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(4, 'Lampu Meja LED', 'Lampu meja LED dengan 3 mode cahaya', 145000, 3, 'https://picsum.photos/seed/lampu/400/400', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
