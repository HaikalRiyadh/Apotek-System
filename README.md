# 💊 Apotek Kita Sehat — Sistem Manajemen Apotek

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel" />
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss" />
  <img src="https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpine.js" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" />
</p>

Sistem manajemen apotek modern berbasis web yang dirancang untuk mengelola **inventori obat**, **pembelian**, **penjualan (POS)**, **laporan keuangan**, dan **notifikasi** secara efisien. Dibangun dengan arsitektur **Laravel 12** + **Breeze** + **Spatie Permission** untuk keamanan berbasis **Role-Based Access Control (RBAC)**.

---

## ✨ Fitur Utama

### 📦 Manajemen Inventori
- CRUD Obat (Medicine) dengan kode unik, kategori, satuan
- **Batch tracking** — setiap pembelian membuat batch baru dengan nomor batch dan tanggal expired
- **FIFO (First In First Out)** — penjualan otomatis mengambil stok dari batch yang expired paling awal
- Stok otomatis ter-recalculate dari batch yang tersisa
- Minimum stock threshold per obat

### 🛒 Pembelian (Purchase)
- Input pembelian dari supplier dengan detail batch (nomor batch, expired date, harga beli)
- Auto-generate nomor invoice (`PUR-YYYYMMDD-####`)
- Stok otomatis bertambah setelah pembelian
- Filter berdasarkan tanggal

### 💰 Penjualan / POS (Point of Sale)
- Interface POS modern dengan pencarian obat real-time (AJAX)
- Auto-generate nomor invoice (`INV-YYYYMMDD-####`)
- Kalkulasi subtotal, diskon, pajak, kembalian
- Metode pembayaran (cash/transfer)
- **FIFO batch consumption** — otomatis ambil dari batch expired terdekat
- Perhitungan laba kotor berdasarkan harga beli aktual (weighted average dari FIFO)

### 📊 Dashboard & Analytics
- Penjualan hari ini & bulan ini
- Total pembelian bulan ini
- Total obat terdaftar & jumlah supplier
- Laba kotor bulan ini
- Chart penjualan 7 hari terakhir (line chart)
- Top 5 obat terlaris (bar chart)
- Peringatan stok rendah & obat mendekati expired

### 📈 Laporan (Reports)
- **Laporan Penjualan** — filter tanggal, total penjualan
- **Laporan Pembelian** — filter tanggal, total pembelian
- **Laporan Stok** — semua obat dengan stok saat ini
- **Obat Expired/Mendekati Expired** — konfigurasi hari
- **Laba Kotor** — revenue vs cost = gross profit (akurasi FIFO)

### 🔔 Notifikasi & Alert
- **Low stock alert** — peringatan obat di bawah minimum stok
- **Expiring medicine alert** — peringatan batch mendekati expired (30 hari)
- Notifikasi real-time di navigation bar (bell icon)
- Scheduled command harian (`pharmacy:check-alerts`)

### 🔍 Search & Filter
- Pencarian obat by nama/kode
- Filter obat by kategori
- Filter penjualan by tanggal
- Filter pembelian by tanggal
- Pencarian supplier by nama/email/telepon
- Search obat real-time di POS (AJAX)

### 📝 Activity Log
- Tracking semua aktivitas CRUD (create, update, delete)
- Log siapa melakukan apa dan kapan
- Halaman activity log untuk admin
- Filter by user, action, dan tanggal

### 🔐 Role-Based Access Control (RBAC)
- 3 Role: **Admin**, **Apoteker**, **Kasir**
- 16 Permission granular
- Middleware protection di setiap route
- UI elements conditional berdasarkan permission

### 🔌 API Endpoint
- RESTful API untuk integrasi eksternal
- Endpoint: medicines, sales, purchases, stock, dashboard stats
- JSON response dengan proper status codes

---

## 🛠 Tech Stack

| Teknologi | Keterangan |
|-----------|------------|
| **Laravel 12** | PHP Framework (Backend) |
| **PHP 8.2+** | Server-side Language |
| **MySQL / MariaDB** | Database |
| **Tailwind CSS 3** | Utility-first CSS Framework |
| **Alpine.js 3** | Reactive JavaScript Framework |
| **Chart.js** | Library Chart/Grafik |
| **Vite** | Build Tool (Frontend) |
| **Laravel Breeze** | Authentication Scaffolding |
| **Spatie Permission** | Role & Permission Management |

---

## 🏗 Arsitektur Sistem

```
┌──────────────────────────────────────────────────────┐
│                    Browser (Client)                  │
│         Tailwind CSS + Alpine.js + Chart.js          │
└──────────────────┬───────────────────────────────────┘
                   │ HTTP Request
┌──────────────────▼───────────────────────────────────┐
│                  Laravel 12 Application              │
│  ┌─────────────────────────────────────────────────┐ │
│  │ Routes (web.php / api.php)                      │ │
│  │   ↓                                             │ │
│  │ Middleware (auth, permission, activity-log)      │ │
│  │   ↓                                             │ │
│  │ Controllers (DashboardController, etc.)          │ │
│  │   ↓                                             │ │
│  │ Services (PurchaseService, SaleService, etc.)    │ │
│  │   ↓                                             │ │
│  │ Models (Medicine, Sale, Purchase, etc.)          │ │
│  │   ↓                                             │ │
│  │ Database (MySQL/MariaDB)                        │ │
│  └─────────────────────────────────────────────────┘ │
│  ┌──────────────┐ ┌──────────────┐ ┌──────────────┐ │
│  │ Notifications│ │  Policies    │ │  Scheduler   │ │
│  └──────────────┘ └──────────────┘ └──────────────┘ │
└──────────────────────────────────────────────────────┘
```

---

## 📋 Persyaratan Sistem

- **PHP** >= 8.2 (dengan extensions: mbstring, xml, ctype, json, bcmath, pdo_mysql)
- **Composer** >= 2.x
- **Node.js** >= 18.x & **npm** >= 9.x
- **MySQL** >= 8.0 atau **MariaDB** >= 10.6
- **Git** (optional, untuk clone repository)

---

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/HaikalRiyadh/Apotek_system.git
cd Apotek_system
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apotek_system
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeder
```bash
php artisan migrate --seed
```

### 6. Build Frontend Assets
```bash
npm run build
```

### 7. Jalankan Server
```bash
php artisan serve
```
Atau gunakan Laragon/XAMPP/Herd.

### Quick Setup (All-in-One)
```bash
composer run setup
```

### Development Mode
```bash
composer run dev
```
Menjalankan server, queue worker, log viewer (pail), dan Vite secara bersamaan.

---

## ⚙ Konfigurasi

### Scheduled Tasks
Tambahkan ke crontab server (production):
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Jadwal otomatis:
| Schedule | Command | Deskripsi |
|----------|---------|-----------|
| Setiap hari 08:00 | `pharmacy:check-alerts` | Cek stok rendah & obat expired |

### Manual Check Alerts
```bash
php artisan pharmacy:check-alerts
```

---

## 📖 Penggunaan

### Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@apotek.com | password |
| **Apoteker** | apoteker@apotek.com | password |
| **Kasir** | kasir@apotek.com | password |

### Alur Kerja Utama

1. **Login** → Masuk sesuai role
2. **Master Data** → Tambah kategori, satuan, supplier, obat
3. **Pembelian** → Input pembelian dari supplier → stok otomatis bertambah
4. **Penjualan (POS)** → Cari obat → tambah ke keranjang → bayar → stok otomatis berkurang (FIFO)
5. **Laporan** → Lihat laporan penjualan, pembelian, stok, expired, laba kotor
6. **Dashboard** → Monitor penjualan, alert stok rendah, obat expired

---

## 🗃 Struktur Database (ERD)

Lihat diagram lengkap di [docs/ERD.md](docs/ERD.md)

### Tabel Utama

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Data user/karyawan |
| `roles` / `permissions` | RBAC (Spatie Permission) |
| `categories` | Kategori obat |
| `units` | Satuan obat (tablet, kapsul, botol, dll) |
| `medicines` | Data obat (kode, nama, harga, stok) |
| `medicine_batches` | Batch per obat (nomor batch, expired, qty tersisa) |
| `suppliers` | Data supplier/distributor |
| `purchases` | Header pembelian |
| `purchase_details` | Detail item pembelian |
| `sales` | Header penjualan |
| `sale_details` | Detail item penjualan |
| `sale_detail_batches` | Tracking FIFO — batch mana yang dikonsumsi |
| `activity_logs` | Log aktivitas user |
| `notifications` | Notifikasi (low stock, expiring) |

---

## 🔌 API Endpoint

Lihat dokumentasi lengkap di [docs/API.md](docs/API.md)

### Base URL
```
GET /api/v1/...
```

### Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/v1/dashboard/stats` | Statistik dashboard |
| GET | `/api/v1/medicines` | Daftar obat (search, filter, paginate) |
| GET | `/api/v1/medicines/{id}` | Detail obat + batch |
| GET | `/api/v1/medicines/low-stock` | Obat stok rendah |
| GET | `/api/v1/medicines/expiring` | Obat mendekati expired |
| GET | `/api/v1/sales` | Daftar penjualan |
| GET | `/api/v1/sales/{id}` | Detail penjualan |
| GET | `/api/v1/purchases` | Daftar pembelian |
| GET | `/api/v1/purchases/{id}` | Detail pembelian |
| GET | `/api/v1/categories` | Daftar kategori |
| GET | `/api/v1/suppliers` | Daftar supplier |
| GET | `/api/v1/reports/sales` | Laporan penjualan |
| GET | `/api/v1/reports/stock` | Laporan stok |

---

## 🔐 Role & Permission

### Role

| Role | Deskripsi |
|------|-----------|
| **Admin** | Akses penuh ke semua fitur |
| **Apoteker** | Manajemen obat, pembelian, lihat penjualan & laporan |
| **Kasir** | Lihat obat, buat penjualan (POS) |

### Permission Matrix

| Permission | Admin | Apoteker | Kasir |
|-----------|:-----:|:--------:|:-----:|
| view dashboard | ✅ | ✅ | ✅ |
| view medicines | ✅ | ✅ | ✅ |
| create medicines | ✅ | ✅ | ❌ |
| edit medicines | ✅ | ✅ | ❌ |
| delete medicines | ✅ | ❌ | ❌ |
| manage categories | ✅ | ✅ | ❌ |
| manage units | ✅ | ✅ | ❌ |
| view suppliers | ✅ | ✅ | ❌ |
| manage suppliers | ✅ | ✅ | ❌ |
| view purchases | ✅ | ✅ | ❌ |
| create purchases | ✅ | ✅ | ❌ |
| view sales | ✅ | ✅ | ❌ |
| create sales | ✅ | ✅ | ✅ |
| view reports | ✅ | ✅ | ❌ |
| manage users | ✅ | ❌ | ❌ |

---

## 🔄 Business Flow

Lihat diagram lengkap di [docs/BUSINESS_FLOW.md](docs/BUSINESS_FLOW.md)

### Flow Ringkas
```
Supplier → Pembelian → Batch Obat (stok naik)
                              ↓
Pelanggan → POS/Penjualan → FIFO Konsumsi Batch (stok turun)
                              ↓
                        Laporan & Laba Kotor
```

---


```

## 🚀 Deployment

### Production Checklist
```bash
# 1. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 2. Build assets
npm run build

# 3. Set environment
APP_ENV=production
APP_DEBUG=false

# 4. Setup scheduler (crontab)
* * * * * cd /path && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/nama-fitur`)
3. Commit perubahan (`git commit -m 'Tambah fitur xxx'`)
4. Push ke branch (`git push origin feature/nama-fitur`)
5. Buat Pull Request

---

---

## 👨‍💻 Developer

Dikembangkan dengan ❤️ by Haikal Riyadh, untuk membantu manajemen apotek Indonesia.

---

<p align="center">
  <strong>💊 Apotek Kita Sehat — Kelola Apotek Anda dengan Mudah & Efisien</strong>
</p>
