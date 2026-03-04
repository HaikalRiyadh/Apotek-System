<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicineBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'batch_number',
        'expired_date',
        'purchase_price',
        'initial_quantity',
        'remaining_quantity',
        'purchase_detail_id',
    ];

    protected function casts(): array
    {
        return [
            'expired_date' => 'date',
            'purchase_price' => 'decimal:2',
        ];
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function purchaseDetail(): BelongsTo
    {
        return $this->belongsTo(PurchaseDetail::class);
    }

    public function saleDetailBatches(): HasMany
    {
        return $this->hasMany(SaleDetailBatch::class);
    }

    public function isExpired(): bool
    {
        return $this->expired_date->isPast();
    }

    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->expired_date->lte(now()->addDays($days)) && !$this->isExpired();
    }
}
