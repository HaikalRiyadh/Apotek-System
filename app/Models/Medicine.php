<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'code',
        'name',
        'category_id',
        'unit_id',
        'default_purchase_price',
        'selling_price',
        'stock_total',
        'minimum_stock',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'default_purchase_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(MedicineBatch::class);
    }

    public function activeBatches(): HasMany
    {
        return $this->hasMany(MedicineBatch::class)
            ->where('remaining_quantity', '>', 0)
            ->orderBy('expired_date', 'asc'); // FIFO by expired
    }

    public function purchaseDetails(): HasMany
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function recalculateStock(): void
    {
        $this->stock_total = $this->batches()->sum('remaining_quantity');
        $this->save();
    }

    public function isLowStock(): bool
    {
        return $this->stock_total <= $this->minimum_stock;
    }

    public function nearestExpiredBatch()
    {
        return $this->batches()
            ->where('remaining_quantity', '>', 0)
            ->where('expired_date', '>', now())
            ->orderBy('expired_date')
            ->first();
    }

    public function expiringSoonBatches(int $days = 30)
    {
        return $this->batches()
            ->where('remaining_quantity', '>', 0)
            ->where('expired_date', '<=', now()->addDays($days))
            ->where('expired_date', '>', now())
            ->get();
    }
}
