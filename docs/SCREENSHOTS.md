# 📸 Screenshot Aplikasi — Apotek Kita Sehat

> Panduan screenshot untuk dokumentasi aplikasi.
> Jalankan aplikasi lalu ambil screenshot sesuai panduan di bawah ini.

---

## Cara Mengambil Screenshot

1. Jalankan aplikasi: `php artisan serve` + `npm run dev`
2. Buka browser: `http://localhost:8000`
3. Gunakan **DevTools** (F12) → klik ikon device → pilih resolusi **1920x1080**
4. Gunakan shortcut **Win + Shift + S** (Windows) untuk screenshot area tertentu
5. Simpan file ke folder `docs/screenshots/`

---

## 📋 Daftar Screenshot yang Dibutuhkan

### 1. Autentikasi
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 1 | Halaman Login | `01-login.png` | — |
| 2 | Halaman Register | `02-register.png` | — |

### 2. Dashboard
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 3 | Dashboard Admin (penuh) | `03-dashboard-admin.png` | admin@apotek.com |
| 4 | Dashboard - Chart Penjualan | `04-dashboard-chart.png` | admin@apotek.com |
| 5 | Dashboard - Alert Stok Rendah | `05-dashboard-low-stock.png` | admin@apotek.com |
| 6 | Dashboard - Alert Obat Expired | `06-dashboard-expiring.png` | admin@apotek.com |

### 3. Master Data - Obat
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 7 | Daftar Obat (index) | `07-medicines-index.png` | admin@apotek.com |
| 8 | Tambah Obat (create) | `08-medicines-create.png` | admin@apotek.com |
| 9 | Detail Obat + Batch (show) | `09-medicines-show.png` | admin@apotek.com |
| 10 | Edit Obat | `10-medicines-edit.png` | admin@apotek.com |
| 11 | Search & Filter Obat | `11-medicines-search.png` | admin@apotek.com |

### 4. Master Data - Kategori & Satuan
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 12 | Daftar Kategori | `12-categories-index.png` | admin@apotek.com |
| 13 | Daftar Satuan | `13-units-index.png` | admin@apotek.com |

### 5. Master Data - Supplier
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 14 | Daftar Supplier | `14-suppliers-index.png` | admin@apotek.com |
| 15 | Tambah Supplier | `15-suppliers-create.png` | admin@apotek.com |

### 6. Pembelian
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 16 | Daftar Pembelian | `16-purchases-index.png` | admin@apotek.com |
| 17 | Form Pembelian Baru | `17-purchases-create.png` | admin@apotek.com |
| 18 | Detail Pembelian | `18-purchases-show.png` | admin@apotek.com |

### 7. Penjualan (POS)
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 19 | Interface POS | `19-pos-interface.png` | kasir@apotek.com |
| 20 | POS - Pencarian Obat | `20-pos-search.png` | kasir@apotek.com |
| 21 | POS - Keranjang Terisi | `21-pos-cart.png` | kasir@apotek.com |
| 22 | POS - Pembayaran | `22-pos-payment.png` | kasir@apotek.com |
| 23 | Daftar Penjualan | `23-sales-index.png` | admin@apotek.com |
| 24 | Detail Penjualan/Struk | `24-sales-show.png` | admin@apotek.com |

### 8. Laporan
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 25 | Laporan Penjualan | `25-report-sales.png` | admin@apotek.com |
| 26 | Laporan Pembelian | `26-report-purchases.png` | admin@apotek.com |
| 27 | Laporan Stok | `27-report-stock.png` | admin@apotek.com |
| 28 | Laporan Obat Expired | `28-report-expiring.png` | admin@apotek.com |
| 29 | Laporan Laba Kotor | `29-report-gross-profit.png` | admin@apotek.com |

### 9. Notifikasi & Alert
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 30 | Notification Bell (dropdown) | `30-notification-bell.png` | admin@apotek.com |
| 31 | Halaman Semua Notifikasi | `31-notifications-all.png` | admin@apotek.com |

### 10. Activity Log
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 32 | Activity Log (index) | `32-activity-log.png` | admin@apotek.com |

### 11. Profil
| No | Halaman | File Name | Akun |
|----|---------|-----------|------|
| 33 | Edit Profile | `33-profile-edit.png` | admin@apotek.com |

### 12. Responsive (Mobile)
| No | Halaman | File Name | Resolusi |
|----|---------|-----------|----------|
| 34 | Dashboard Mobile | `34-mobile-dashboard.png` | 375x812 |
| 35 | POS Mobile | `35-mobile-pos.png` | 375x812 |
| 36 | Navigation Mobile | `36-mobile-nav.png` | 375x812 |

---

## 📁 Struktur Folder Screenshot

```
docs/
└── screenshots/
    ├── 01-login.png
    ├── 02-register.png
    ├── 03-dashboard-admin.png
    ├── ...
    └── 36-mobile-nav.png
```

---

## 🔧 Tools Rekomendasi untuk Screenshot

| Tool | Platform | Keterangan |
|------|----------|------------|
| **Snipping Tool** | Windows | Bawaan Windows, Win+Shift+S |
| **Lightshot** | Windows/Mac | Gratis, mudah digunakan |
| **ShareX** | Windows | Open source, banyak fitur |
| **Full Page Screenshot** | Chrome Extension | Capture full page |
| **Firefox Screenshot** | Firefox | Bawaan Firefox (Ctrl+Shift+S) |

---

> **Tips:** Pastikan ada data sample (dari seeder) sebelum mengambil screenshot agar tampilan tidak kosong.
