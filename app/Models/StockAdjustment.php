<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_batch_id',
        'medicine_id',
        'user_id',
        'type',
        'quantity_before',
        'quantity_adjusted',
        'quantity_after',
        'reason',
    ];

    public const TYPE_LABELS = [
        'dispose' => 'Buang/Expired',
        'correction' => 'Koreksi Stok',
        'return' => 'Retur Supplier',
        'other' => 'Lainnya',
    ];

    public function medicineBatch(): BelongsTo
    {
        return $this->belongsTo(MedicineBatch::class);
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? $this->type;
    }
}
