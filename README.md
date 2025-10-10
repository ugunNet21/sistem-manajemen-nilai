# Sistem Penilaian Siswa

## About
Project ini adalah aplikasi sederhana untuk mengelola data nilai siswa, dibuat sebagai bagian dari technical test recruitment. Aplikasi ini mempermudah penilaian terhadap siswa dengan fitur authentication, CRUD (Create, Read, Update, Delete), serta import/export data dalam format Excel. Hal ini membuat proses pengelolaan data lebih transparan dan efisien.

## Arsitektur
Project ini menggunakan arsitektur yang digabung:
- **Laravel** sebagai backend
- **Vue 3** sebagai frontend
- **Inertia.js** untuk menghubungkan keduanya
- **Tailwind CSS** untuk styling

### Alasan Memilih Arsitektur
Arsitektur ini dipilih karena memungkinkan pengembangan full-stack yang terintegrasi dengan baik, di mana Laravel menangani routing dan rendering Vue components secara seamless melalui Inertia.js. Ini lebih sederhana dibandingkan memisahkan backend sebagai REST API murni dan frontend sebagai SPA terpisah, karena mengurangi overhead dalam pengelolaan API endpoints dan authentication. Selain itu, Inertia.js mendukung pengembangan cepat dengan tetap mempertahankan manfaat SSR (Server-Side Rendering) dari Laravel, yang cocok untuk aplikasi sederhana seperti ini.

Struktur project mengikuti **Clean Code Architecture**, dengan pemisahan tanggung jawab menggunakan:
- Service
- Repository
- Controller
- Dependency Injection (DI)
- Request validation
- Interface

Hal ini memastikan kode yang maintainable dan testable.

## Prerequisites
- PHP >= 8.2 (untuk Laravel 12)
- Composer (untuk menginstall dependencies PHP)
- Node.js >= 18.x dan NPM (untuk frontend Vue dan Tailwind)
- PostgreSQL (direkomendasikan, meskipun MySQL juga bisa digunakan)
- Git (untuk clone repository)

## Installation
Ikuti langkah-langkah berikut untuk menginstall dan menjalankan project. Pastikan semua prerequisites sudah terinstall.

### 1. Clone Repository
Clone project dari GitHub:
```bash
git clone https://git@github.com:ugunNet21/sistem-manajemen-nilai.git
cd repo-name
```

### 2. Setup Database (PostgreSQL)
1. Jalankan PostgreSQL server.
2. Buat database baru bernama `db_sistem_nilai`.
3. Buat user database dengan hak akses yang diperlukan. Jalankan perintah berikut sebagai superuser (misalnya, user `postgres`):
```bash
sudo -u postgres psql
```
4. Di dalam psql shell, jalankan perintah SQL berikut:
```sql
CREATE DATABASE db_sistem_nilai;
CREATE USER user123 WITH PASSWORD 'passwordku123';
GRANT CONNECT ON DATABASE db_sistem_nilai TO user123;
GRANT USAGE, CREATE ON SCHEMA public TO user123;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO user123;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO user123;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO user123;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO user123;
\q
```
5. Verifikasi koneksi:
```bash
psql -h localhost -U user123 -d db_sistem_nilai
```
Masukkan password `passwordku123` saat diminta. Jika berhasil, Anda akan masuk ke shell psql.

### 3. Konfigurasi Environment (.env)
1. Copy file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
2. Edit file `.env` dengan detail database Anda:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db_sistem_nilai
DB_USERNAME=user123
DB_PASSWORD=passwordku123
```
3. Generate app key:
```bash
php artisan key:generate
```

### 4. Install Dependencies
1. Install PHP dependencies via Composer:
```bash
composer install
```
2. Install library tambahan (Jetstream untuk authentication, Spatie):
```bash
composer require laravel/jetstream
php artisan jetstream:install inertia
composer require spatie/laravel-permission 
# Atau spatie/laravel-excel untuk import/export
```
**Catatan**: Spatie telah dicustom untuk menggunakan UUID pada model.
3. Install Node.js dependencies untuk frontend:
```bash
npm install
```

### 5. Jalankan Migration dan Seeder
1. Jalankan migration untuk membuat tabel database (siswa dan nilai, beserta tabel default seperti users, sessions, dll.):
```bash
php artisan migrate
```
2. Jika ada seeder untuk data awal (misalnya, user contoh), jalankan:
```bash
php artisan db:seed
```

### 6. Compile Assets
Build frontend assets:
```bash
npm run build
```

## How to Run the Project
1. **Jalankan Server Laravel**
```bash
php artisan serve
```
Aplikasi akan berjalan di `http://127.0.0.1:8000`.

2. **Jalankan Development Server untuk Frontend** (opsional untuk hot-reloading)
```bash
npm run dev
```

3. **Akses Aplikasi**
Buka browser dan kunjungi `http://127.0.0.1:8000`. Halaman login akan muncul. Gunakan akun contoh untuk login.

### Contoh Akun User untuk Login
- **Email**: `zaki@sekolahku.com`
- **Password**: `password`

**Catatan**: Anda bisa register user baru melalui halaman register jika fitur tersebut diaktifkan.

## Fitur Tambahan
- Validasi input pada form (menggunakan Laravel Request validation).
- Filter data pada dashboard (misalnya, berdasarkan nama siswa atau mapel).
- Styling rapi menggunakan Tailwind CSS.
- Menggunakan migration untuk setup database.
