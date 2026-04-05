# 🥗 Self-Ordering Healthy Food System

> **Website Pemesanan Mandiri Makanan Sehat dengan Pelacakan Nutrisi Cerdas.**

Sistem ini dirancang untuk merevolusi cara pengguna memesan makanan sehat dengan memberikan transparansi penuh terhadap informasi gizi (Kalori, Protein, Karbohidrat, Lemak) dan membantu mereka mencapai target kesehatan melalui fitur pelacakan nutrisi otomatis.

---

## 🌟 Fitur Utama

### 🛒 Untuk Pelanggan (Customer)
- **Self-Ordering System**: Antarmuka modern untuk memilih menu dan melakukan pemesanan secara mandiri.
- **Smart Dietary Filters**: Temukan menu yang sesuai dengan diet Anda:
  - 🥦 Vegetarian & Vegan
  - 🥛 Dairy-Free
  - 🌾 Gluten-Free
  - 🔥 Low-Calorie
- **Live Nutrition Tracking**: Lacak total asupan gizi harian secara otomatis berdasarkan riwayat pesanan yang telah selesai.
- **Order History & Status**: Pantau status pesanan (Pending, Processing, Completed) secara real-time.

### 🛡️ Untuk Pengelola (Admin Dashboard)
- **Comprehensive Analytics**: Visualisasi data penjualan, preferensi pelanggan, dan analitik nutrisi.
- **Menu & Category Management**: Kelola data makanan, stok, harga, dan informasi gizi dengan mudah.
- **Order Management**: Proses pesanan masuk, pantau status pembayaran, dan kelola pengiriman.
- **Customer Insights**: Lihat riwayat aktivitas dan preferensi diet pelanggan untuk strategi pemasaran yang lebih baik.

---

## 📈 Project Roadmap & Requirements

### **Project Timeline (2 Bulan)**

| Fase | Durasi | Deskripsi |
| :--- | :--- | :--- |
| **Discovery & Research** | 1 Minggu | Riset target user, pemetaan database nutrisi, dan perancangan alur UX. |
| **UI/UX Design** | 1 Minggu | Pembuatan wireframe dan mockup high-fidelity yang modern & responsif. |
| **Frontend Development** | 2 Minggu | Implementasi UI menggunakan Bootstrap 5, Vite, dan integrasi komponen interaktif. |
| **Backend Integration** | 3 Minggu | Pengembangan logika bisnis Laravel (Auth, Order, Nutrition Tracking). |
| **QA & Launch** | 1 Minggu | Pengujian menyeluruh, bug fixing, dan deployment fase final. |

### **Project Requirements**
- [x] **Comprehensive Nutrition Tracking**: Perhitungan gizi otomatis (Calories, Protein, Carbs, Fat).
- [x] **Multi-Tier Dietary Filters**: Filter cerdas berdasarkan kebutuhan diet spesifik.
- [x] **Interactive Admin Analytics**: Dashboard visual untuk tren penjualan dan data nutrisi.
- [x] **Role-Based Access Control**: Pemisahan akses antara Customer dan Admin.
- [x] **Mobile-Responsive Interface**: Optimal di perangkat Tablet maupun Smartphone.
- [x] **Sub-1.5 Second Load Target**: Optimasi performa untuk pengalaman ordering yang instan.

---

## 🛠️ Teknologi yang Digunakan

- **Core Framework**: [Laravel 10](https://laravel.com) (PHP 8.1+)
- **Frontend Engine**: [Vite](https://vitejs.dev) & Blade Templates
- **Styling**: Bootstrap 5 & Vanilla CSS
- **Database**: MySQL / MariaDB
- **JavaScript**: Axios for AJAX Requests
- **Icons**: FontAwesome & Custom SVG Assets

---

## 🚀 Cara Instalasi Lokal

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/MichaelAntolis/Self-Ordering-Healthy-Food-System-Website-Development.git
   cd Self-Ordering-Healthy-Food-System-Website-Development
   ```

2. **Instal Dependensi**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   Salin `.env.example` ke `.env` dan sesuaikan pengaturan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`.

4. **Setup Database**:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**:
   ```bash
   php artisan serve
   # Di terminal lain
   npm run dev
   ```

---

## 🔐 Akun Akses (Data Seeder)

Gunakan akun berikut untuk mencoba fitur setelah menjalankan `--seed`:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@healthyfood.com` | `admin123` |
| **Customer** | `budi@example.com` | `password123` |

---

Developed with ❤️ by **[Michael Antolis](https://github.com/MichaelAntolis)**
