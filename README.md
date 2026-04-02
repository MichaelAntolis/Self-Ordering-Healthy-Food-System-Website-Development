# Self-Ordering Healthy Food System

Website sistem pemesanan makanan sehat mandiri (Self-Ordering) yang dirancang untuk membantu pengguna memilih makanan berdasarkan kebutuhan nutrisi mereka. Sistem ini mendukung pelacakan nutrisi, manajemen kategori makanan, dan sistem peran pengguna (Admin dan Customer).

## Fitur Utama

-   **Pemesanan Mandiri**: Pelanggan dapat memilih makanan dan melakukan pemesanan secara langsung.
-   **Pelacakan Nutrisi**: Setiap menu makanan dilengkapi dengan informasi kalori, protein, karbohidrat, dan lemak yang akan terakumulasi pada profil pengguna.
-   **Manajemen Menu**: Kategori makanan yang variatif (Makanan Utama, Smoothie, Salad, dll).
-   **Sistem Role**: 
    -   **Admin**: Mengelola menu, kategori, dan melihat ringkasan pesanan.
    -   **Customer**: Melakukan pemesanan, melihat riwayat pesanan, dan melacak asupan nutrisi.
-   **Filter Diet**: Filter makanan berdasarkan kategori vegetarian, vegan, dairy-free, gluten-free, dan low-calorie.

## Prasyarat

Sebelum memulai, pastikan Anda telah menginstal:
-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   MySQL atau MariaDB (XAMPP/Laragon)

## Cara Instalasi Secara Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan project di komputer Anda:

### 1. Clone Repositori
Buka terminal/command prompt dan jalankan perintah:
```bash
git clone https://github.com/MichaelAntolis/Self-Ordering-Healthy-Food-System-Website-Development.git
cd Self-Ordering-Healthy-Food-System-Website-Development
```

### 2. Instal Dependensi Backend (PHP)
```bash
composer install
```

### 3. Instal Dependensi Frontend (JavaScript/CSS)
```bash
npm install
```

### 4. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Kemudian, buka file `.env` dan sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```
*Catatan: Buatlah database kosong di phpMyAdmin atau MySQL dengan nama yang sesuai dengan `DB_DATABASE`.*

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Migrasi dan Seeding Database
Jalankan perintah ini untuk membuat tabel-tabel database sekaligus mengisi data awal (termasuk akun admin):
```bash
php artisan migrate --seed
```

### 7. Jalankan Server Lokal
Buka dua terminal terpisah. 

**Terminal 1 (Laravel Server):**
```bash
php artisan serve
```

**Terminal 2 (Vite/Asset Bundler):**
```bash
npm run dev
```

Sekarang Anda bisa mengakses website melalui browser di alamat: `http://127.0.0.1:8000`

## Akun Login (Data Seed)

Anda dapat menggunakan akun berikut untuk testing setelah melakukan `--seed`:

-   **Admin**: 
    -   Email: `admin@healthyfood.com`
    -   Password: `admin123`
-   **Customer**: 
    -   Email: `budi@example.com`
    -   Password: `password123`

## Teknologi yang Digunakan

-   **Framework**: [Laravel 10](https://laravel.com)
-   **Frontend**: [Vite](https://vitejs.dev), Blade Templates, Vanilla CSS/Tailwind (opsional/tergantung implementasi)
-   **Database**: MySQL
-   **Icons/Images**: FontAwesome / Asset Lokal

---
Developed by [Michael Antolis](https://github.com/MichaelAntolis)
