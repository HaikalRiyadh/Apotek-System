# 🔌 API Endpoint Documentation — Apotek Kita Sehat

## Base URL
```
http://localhost:8000/api/v1
```

## Authentication
Semua API endpoint memerlukan autentikasi via `sanctum` token.

### Login & Mendapatkan Token
```http
POST /api/v1/auth/login
Content-Type: application/json

{
    "email": "admin@apotek.com",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "token": "1|abc123...",
        "user": {
            "id": 1,
            "name": "Admin",
            "email": "admin@apotek.com",
            "role": "Admin"
        }
    }
}
```

### Menggunakan Token
```http
Authorization: Bearer {token}
```

---

## Endpoints

### 📊 Dashboard

#### GET `/api/v1/dashboard/stats`
Mendapatkan statistik dashboard.

**Response:**
```json
{
    "success": true,
    "data": {
        "sales_today": 1500000,
        "sales_this_month": 45000000,
        "purchases_this_month": 30000000,
        "total_medicines": 150,
        "total_suppliers": 10,
        "low_stock_count": 5,
        "expiring_count": 3,
        "gross_profit_this_month": 15000000
    }
}
```

---

### 💊 Medicines (Obat)

#### GET `/api/v1/medicines`
Daftar obat dengan pagination, search, dan filter.

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `search` | string | Cari berdasarkan nama atau kode |
| `category_id` | integer | Filter berdasarkan kategori |
| `page` | integer | Halaman (default: 1) |
| `per_page` | integer | Per halaman (default: 15) |

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "code": "MED001",
            "name": "Paracetamol 500mg",
            "category": { "id": 1, "name": "Analgesik" },
            "unit": { "id": 1, "name": "Tablet", "abbreviation": "tab" },
            "default_purchase_price": 3500.00,
            "selling_price": 5000.00,
            "stock_total": 250,
            "minimum_stock": 50
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 10,
        "per_page": 15,
        "total": 150
    }
}
```

#### GET `/api/v1/medicines/{id}`
Detail obat beserta batch.

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "code": "MED001",
        "name": "Paracetamol 500mg",
        "category": { "id": 1, "name": "Analgesik" },
        "unit": { "id": 1, "name": "Tablet" },
        "default_purchase_price": 3500.00,
        "selling_price": 5000.00,
        "stock_total": 250,
        "minimum_stock": 50,
        "description": "Obat penurun demam dan pereda nyeri",
        "batches": [
            {
                "id": 1,
                "batch_number": "BTH-001",
                "expired_date": "2026-09-15",
                "purchase_price": 3500.00,
                "initial_quantity": 200,
                "remaining_quantity": 150
            }
        ]
    }
}
```

#### GET `/api/v1/medicines/low-stock`
Daftar obat dengan stok di bawah minimum.

#### GET `/api/v1/medicines/expiring`
Daftar batch yang mendekati expired.

**Query Parameters:**
| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `days` | integer | 30 | Berapa hari ke depan |

---

### 💰 Sales (Penjualan)

#### GET `/api/v1/sales`
Daftar penjualan dengan filter tanggal.

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `start_date` | date | Tanggal awal (YYYY-MM-DD) |
| `end_date` | date | Tanggal akhir (YYYY-MM-DD) |
| `page` | integer | Halaman |

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "invoice_number": "INV-20260305-0001",
            "sale_date": "2026-03-05",
            "grand_total": 150000.00,
            "payment_method": "cash",
            "user": { "id": 3, "name": "Kasir" }
        }
    ],
    "meta": { "current_page": 1, "total": 50 }
}
```

#### GET `/api/v1/sales/{id}`
Detail penjualan lengkap.

---

### 🛒 Purchases (Pembelian)

#### GET `/api/v1/purchases`
Daftar pembelian dengan filter tanggal.

#### GET `/api/v1/purchases/{id}`
Detail pembelian lengkap.

---

### 📦 Categories & Suppliers

#### GET `/api/v1/categories`
Daftar semua kategori.

#### GET `/api/v1/suppliers`
Daftar semua supplier.

---

### 📈 Reports

#### GET `/api/v1/reports/sales`
Laporan penjualan.

**Query Parameters:**
| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `start_date` | date | Awal bulan | Start range |
| `end_date` | date | Hari ini | End range |

**Response:**
```json
{
    "success": true,
    "data": {
        "total_sales": 45000000,
        "total_transactions": 150,
        "sales": [...]
    }
}
```

#### GET `/api/v1/reports/stock`
Laporan stok semua obat.

---

## Error Response Format

```json
{
    "success": false,
    "message": "Error description",
    "errors": {
        "field_name": ["validation error message"]
    }
}
```

## HTTP Status Codes

| Code | Description |
|------|-------------|
| 200 | OK — Request berhasil |
| 401 | Unauthorized — Token tidak valid |
| 403 | Forbidden — Tidak punya akses |
| 404 | Not Found — Resource tidak ditemukan |
| 422 | Unprocessable Entity — Validasi gagal |
| 500 | Server Error — Kesalahan server |
