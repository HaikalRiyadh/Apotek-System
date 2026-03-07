# 🗃 Entity Relationship Diagram (ERD)

## Diagram ERD — Apotek Kita Sehat

```mermaid
erDiagram
    %% ========== USER & AUTH ==========
    users {
        bigint id PK
        varchar name
        varchar email UK
        timestamp email_verified_at
        varchar password
        varchar remember_token
        timestamp created_at
        timestamp updated_at
    }

    roles {
        bigint id PK
        varchar name UK
        varchar guard_name
        timestamp created_at
        timestamp updated_at
    }

    permissions {
        bigint id PK
        varchar name UK
        varchar guard_name
        timestamp created_at
        timestamp updated_at
    }

    model_has_roles {
        bigint role_id FK
        varchar model_type
        bigint model_id FK
    }

    model_has_permissions {
        bigint permission_id FK
        varchar model_type
        bigint model_id FK
    }

    role_has_permissions {
        bigint permission_id FK
        bigint role_id FK
    }

    %% ========== MASTER DATA ==========
    categories {
        bigint id PK
        varchar name
        varchar description
        timestamp created_at
        timestamp updated_at
    }

    units {
        bigint id PK
        varchar name
        varchar abbreviation
        timestamp created_at
        timestamp updated_at
    }

    suppliers {
        bigint id PK
        varchar name
        varchar phone
        varchar email
        text address
        varchar contact_person
        timestamp created_at
        timestamp updated_at
    }

    %% ========== MEDICINES & BATCHES ==========
    medicines {
        bigint id PK
        varchar code UK
        varchar name
        bigint category_id FK
        bigint unit_id FK
        decimal default_purchase_price
        decimal selling_price
        int stock_total
        int minimum_stock
        text description
        timestamp created_at
        timestamp updated_at
    }

    medicine_batches {
        bigint id PK
        bigint medicine_id FK
        varchar batch_number
        date expired_date
        decimal purchase_price
        int initial_quantity
        int remaining_quantity
        bigint purchase_detail_id FK
        timestamp created_at
        timestamp updated_at
    }

    %% ========== PURCHASES ==========
    purchases {
        bigint id PK
        varchar invoice_number UK
        bigint supplier_id FK
        bigint user_id FK
        date purchase_date
        decimal total_amount
        text notes
        enum status
        timestamp created_at
        timestamp updated_at
    }

    purchase_details {
        bigint id PK
        bigint purchase_id FK
        bigint medicine_id FK
        int quantity
        decimal purchase_price
        decimal subtotal
        varchar batch_number
        date expired_date
        timestamp created_at
        timestamp updated_at
    }

    %% ========== SALES ==========
    sales {
        bigint id PK
        varchar invoice_number UK
        bigint user_id FK
        date sale_date
        decimal subtotal
        decimal discount
        decimal tax
        decimal grand_total
        varchar payment_method
        decimal amount_paid
        decimal change_amount
        text notes
        timestamp created_at
        timestamp updated_at
    }

    sale_details {
        bigint id PK
        bigint sale_id FK
        bigint medicine_id FK
        int quantity
        decimal selling_price
        decimal purchase_price_avg
        decimal subtotal
        timestamp created_at
        timestamp updated_at
    }

    sale_detail_batches {
        bigint id PK
        bigint sale_detail_id FK
        bigint medicine_batch_id FK
        int quantity_taken
        decimal purchase_price
        timestamp created_at
        timestamp updated_at
    }

    %% ========== ACTIVITY LOG ==========
    activity_logs {
        bigint id PK
        bigint user_id FK
        varchar action
        varchar model_type
        bigint model_id
        json old_values
        json new_values
        varchar ip_address
        text user_agent
        timestamp created_at
        timestamp updated_at
    }

    %% ========== NOTIFICATIONS ==========
    notifications {
        uuid id PK
        varchar type
        varchar notifiable_type
        bigint notifiable_id
        text data
        timestamp read_at
        timestamp created_at
        timestamp updated_at
    }

    %% ========== RELATIONSHIPS ==========
    users ||--o{ model_has_roles : "has"
    roles ||--o{ model_has_roles : "assigned to"
    users ||--o{ model_has_permissions : "has"
    permissions ||--o{ model_has_permissions : "assigned to"
    roles ||--o{ role_has_permissions : "has"
    permissions ||--o{ role_has_permissions : "belongs to"

    categories ||--o{ medicines : "has many"
    units ||--o{ medicines : "has many"

    medicines ||--o{ medicine_batches : "has many batches"

    suppliers ||--o{ purchases : "supplies"
    users ||--o{ purchases : "created by"
    purchases ||--o{ purchase_details : "has items"
    medicines ||--o{ purchase_details : "purchased"
    purchase_details ||--o| medicine_batches : "creates batch"

    users ||--o{ sales : "cashier"
    sales ||--o{ sale_details : "has items"
    medicines ||--o{ sale_details : "sold"
    sale_details ||--o{ sale_detail_batches : "consumed from"
    medicine_batches ||--o{ sale_detail_batches : "consumed by"

    users ||--o{ activity_logs : "performed by"
    users ||--o{ notifications : "notified"
```

---

## 📝 Penjelasan Relasi

### 1. Users & RBAC
- Setiap **User** memiliki satu atau lebih **Role** (Admin, Apoteker, Kasir)
- Setiap **Role** memiliki banyak **Permission**
- Menggunakan Spatie `laravel-permission` (polymorphic many-to-many)

### 2. Master Data
- **Category** → many **Medicine** (Analgesik, Antibiotik, dll)
- **Unit** → many **Medicine** (Tablet, Kapsul, Botol, dll)
- **Supplier** → many **Purchase** (PT Kimia Farma, dll)

### 3. Medicine & Batch Tracking
- Setiap **Medicine** memiliki banyak **MedicineBatch**
- Setiap batch mencatat: nomor batch, tanggal expired, harga beli, qty awal, qty tersisa
- `stock_total` pada Medicine = SUM(`remaining_quantity`) dari semua batch aktif

### 4. Purchase Flow
```
Purchase (header)
  └── PurchaseDetail (item)
        └── MedicineBatch (stok baru) → Medicine.stock_total naik
```

### 5. Sale Flow (FIFO)
```
Sale (header)
  └── SaleDetail (item)
        └── SaleDetailBatch (tracking FIFO)
              └── MedicineBatch.remaining_quantity turun
                    └── Medicine.stock_total turun
```

### 6. FIFO Logic
- Saat penjualan, sistem mengambil stok dari batch dengan `expired_date` **paling awal** (First Expired First Out)
- Jika satu batch tidak cukup, lanjut ke batch berikutnya
- `purchase_price_avg` dihitung dari weighted average harga beli batch yang dikonsumsi

---

## 📊 Statistik Database

| Tabel | Kolom | Deskripsi |
|-------|-------|-----------|
| users | 7 | Data karyawan/user |
| categories | 4 | Kategori obat |
| units | 4 | Satuan obat |
| medicines | 11 | Master obat |
| medicine_batches | 9 | Batch/lot per obat |
| suppliers | 7 | Data supplier |
| purchases | 9 | Header pembelian |
| purchase_details | 8 | Detail pembelian |
| sales | 12 | Header penjualan |
| sale_details | 7 | Detail penjualan |
| sale_detail_batches | 5 | Tracking FIFO |
| activity_logs | 10 | Audit trail |
| notifications | 7 | Notifikasi sistem |
| **Total** | **~100** | **13 tabel utama** |
