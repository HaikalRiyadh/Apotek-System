# 🔄 Business Flow Diagram — Apotek Kita Sehat

## 1. Alur Bisnis Utama (Main Business Flow)

```mermaid
flowchart TD
    A[🔐 Login] --> B{Role User?}
    
    B -->|Admin| C[📊 Dashboard Admin]
    B -->|Apoteker| D[📊 Dashboard Apoteker]
    B -->|Kasir| E[💰 POS / Kasir]
    
    C --> F[📦 Manajemen Master Data]
    C --> G[🛒 Pembelian]
    C --> H[💰 Penjualan POS]
    C --> I[📈 Laporan]
    C --> J[👥 Manajemen User]
    C --> K[📝 Activity Log]
    
    D --> F
    D --> G
    D --> L[👁 Lihat Penjualan]
    D --> I
    
    E --> H
    
    F --> F1[Kategori CRUD]
    F --> F2[Satuan CRUD]
    F --> F3[Supplier CRUD]
    F --> F4[Obat CRUD]
    
    G --> G1[Input Pembelian]
    G1 --> G2[Pilih Supplier]
    G2 --> G3[Tambah Item Obat]
    G3 --> G4[Input Batch & Expired]
    G4 --> G5[Simpan Pembelian]
    G5 --> G6[✅ Stok Otomatis Bertambah]
    
    H --> H1[Cari Obat - AJAX]
    H1 --> H2[Tambah ke Keranjang]
    H2 --> H3[Input Diskon & Pajak]
    H3 --> H4[Bayar]
    H4 --> H5[✅ FIFO Batch Consumption]
    H5 --> H6[✅ Stok Otomatis Berkurang]
    H6 --> H7[🧾 Struk/Invoice]
    
    I --> I1[Laporan Penjualan]
    I --> I2[Laporan Pembelian]
    I --> I3[Laporan Stok]
    I --> I4[Obat Expired]
    I --> I5[Laba Kotor]
```

---

## 2. Alur Pembelian (Purchase Flow)

```mermaid
flowchart LR
    A[👤 Apoteker/Admin] --> B[Halaman Pembelian]
    B --> C[Klik Tambah Pembelian]
    C --> D[Pilih Supplier]
    D --> E[Set Tanggal Pembelian]
    E --> F[Tambah Item Obat]
    
    F --> G{Input Detail Item}
    G --> G1[Pilih Obat]
    G --> G2[Input Jumlah]
    G --> G3[Input Harga Beli]
    G --> G4[Input No. Batch]
    G --> G5[Input Tanggal Expired]
    
    G1 & G2 & G3 & G4 & G5 --> H[Tambah Item Lain?]
    H -->|Ya| F
    H -->|Tidak| I[Simpan Pembelian]
    
    I --> J[🔄 Proses di Service Layer]
    
    J --> K[Generate Invoice PUR-YYYYMMDD-####]
    J --> L[Buat Purchase Header]
    J --> M[Buat Purchase Details]
    J --> N[Buat Medicine Batches]
    J --> O[Update Medicine.stock_total]
    J --> P[Hitung total_amount]
    
    K & L & M & N & O & P --> Q[✅ Pembelian Tersimpan]
    Q --> R[📄 Halaman Detail Pembelian]
```

---

## 3. Alur Penjualan POS (Sales/POS Flow)

```mermaid
flowchart TD
    A[👤 Kasir/Apoteker/Admin] --> B[Halaman POS]
    B --> C[🔍 Cari Obat - Ketik Nama/Kode]
    C --> D[AJAX Request ke Server]
    D --> E[Hasil Pencarian Muncul]
    E --> F[Klik Obat → Tambah ke Keranjang]
    
    F --> G[Set Jumlah]
    G --> H{Stok Cukup?}
    H -->|Tidak| I[❌ Error: Stok Tidak Cukup]
    H -->|Ya| J[Obat Masuk Keranjang]
    
    J --> K[Tambah Obat Lain?]
    K -->|Ya| C
    K -->|Tidak| L[Review Keranjang]
    
    L --> M[Input Diskon & Pajak]
    M --> N[Lihat Grand Total]
    N --> O[Input Jumlah Bayar]
    O --> P[Pilih Metode: Cash/Transfer]
    P --> Q[Klik Bayar]
    
    Q --> R[🔄 FIFO Batch Processing]
    
    R --> S[Ambil Batch Expired Terdekat]
    S --> T{Batch Cukup?}
    T -->|Tidak| U[Ambil Batch Berikutnya]
    U --> S
    T -->|Ya| V[Kurangi remaining_quantity]
    
    V --> W[Catat SaleDetailBatch]
    W --> X[Hitung purchase_price_avg - Weighted Average]
    X --> Y[Update Medicine.stock_total]
    Y --> Z[Generate Invoice INV-YYYYMMDD-####]
    Z --> AA[✅ Penjualan Tersimpan]
    AA --> AB[🧾 Tampilkan Struk/Invoice]
```

---

## 4. Alur FIFO Batch Consumption

```mermaid
flowchart TD
    A[Obat X - Qty: 50] --> B[Cari Batch Aktif]
    B --> C[ORDER BY expired_date ASC]
    
    C --> D[Batch 1: Exp 2026-04-01 - Sisa: 20]
    C --> E[Batch 2: Exp 2026-06-15 - Sisa: 80]
    C --> F[Batch 3: Exp 2026-09-30 - Sisa: 50]
    
    D --> G{Ambil dari Batch 1}
    G --> G1[Ambil 20 dari Batch 1]
    G1 --> G2[Batch 1 sisa: 0]
    G2 --> H[Masih butuh: 30]
    
    H --> I{Ambil dari Batch 2}
    I --> I1[Ambil 30 dari Batch 2]
    I1 --> I2[Batch 2 sisa: 50]
    
    I2 --> J[✅ Total Diambil: 50]
    J --> K[Hitung Weighted Avg Price]
    K --> L["(20 × Rp5.000 + 30 × Rp5.200) / 50 = Rp5.120"]
    L --> M[purchase_price_avg = Rp5.120]
```

---

## 5. Alur Notifikasi & Alert

```mermaid
flowchart TD
    A[⏰ Scheduler: Setiap Hari 08:00] --> B[Command: pharmacy:check-alerts]
    
    B --> C{Cek Stok Rendah}
    C --> D[Query: stock_total <= minimum_stock]
    D --> E{Ada Obat Stok Rendah?}
    E -->|Ya| F[Kirim LowStockNotification ke Admin]
    E -->|Tidak| G[Skip]
    
    B --> H{Cek Obat Expired}
    H --> I[Query: expired_date <= 30 hari]
    I --> J{Ada Batch Mendekati Expired?}
    J -->|Ya| K[Kirim ExpiringMedicineNotification ke Admin]
    J -->|Tidak| L[Skip]
    
    F --> M[🔔 Notifikasi Muncul di Bell Icon]
    K --> M
    M --> N[Admin Buka Notifikasi]
    N --> O[Mark as Read]
```

---

## 6. Alur Laporan (Reporting Flow)

```mermaid
flowchart LR
    A[📈 Menu Laporan] --> B{Pilih Jenis}
    
    B --> C[Laporan Penjualan]
    C --> C1[Filter: Tanggal Awal - Akhir]
    C1 --> C2[Tampilkan Daftar + Total]
    
    B --> D[Laporan Pembelian]
    D --> D1[Filter: Tanggal Awal - Akhir]
    D1 --> D2[Tampilkan Daftar + Total]
    
    B --> E[Laporan Stok]
    E --> E1[Semua Obat + Stok Saat Ini]
    
    B --> F[Obat Expired/Hampir Expired]
    F --> F1[Konfigurasi: Berapa Hari?]
    F1 --> F2[Daftar Batch + Sisa + Tanggal]
    
    B --> G[Laba Kotor]
    G --> G1[Filter: Tanggal Awal - Akhir]
    G1 --> G2[Revenue - Cost = Gross Profit]
    G2 --> G3[Akurasi FIFO: Harga Beli Aktual]
```

---

## 7. Alur RBAC (Role-Based Access Control)

```mermaid
flowchart TD
    A[HTTP Request] --> B[Auth Middleware]
    B --> C{User Login?}
    C -->|Tidak| D[Redirect ke Login]
    C -->|Ya| E[Permission Middleware]
    
    E --> F{Punya Permission?}
    F -->|Tidak| G[403 Forbidden]
    F -->|Ya| H[Proses Request]
    
    H --> I[Controller]
    I --> J[Blade View]
    J --> K{Cek @can directive}
    K --> L[Tampilkan/Sembunyikan UI Element]
    
    subgraph Roles
        R1[Admin - 16 permissions]
        R2[Apoteker - 12 permissions]
        R3[Kasir - 3 permissions]
    end
```

---

## 8. Alur Data Keseluruhan (Data Flow Overview)

```mermaid
flowchart TD
    subgraph Input
        A1[📦 Pembelian dari Supplier]
        A2[💰 Penjualan ke Pelanggan]
    end
    
    subgraph Processing
        B1[Purchase Service]
        B2[Sale Service]
        B3[Report Service]
    end
    
    subgraph Database
        C1[(medicines)]
        C2[(medicine_batches)]
        C3[(purchases)]
        C4[(purchase_details)]
        C5[(sales)]
        C6[(sale_details)]
        C7[(sale_detail_batches)]
    end
    
    subgraph Output
        D1[📊 Dashboard Analytics]
        D2[📈 Laporan]
        D3[🔔 Notifikasi]
        D4[🧾 Invoice/Struk]
    end
    
    A1 --> B1
    B1 --> C3 & C4 & C2
    B1 --> C1
    
    A2 --> B2
    B2 --> C5 & C6 & C7
    B2 --> C2 & C1
    
    C1 & C2 & C5 & C6 --> B3
    B3 --> D1 & D2
    
    C1 & C2 --> D3
    C5 & C6 --> D4
```
