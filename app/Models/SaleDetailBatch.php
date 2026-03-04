<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetailBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_detail_id',
        'medicine_batch_id',
        'quantity_taken',
        'purchase_price',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
        ];
    }

    public function saleDetail(): BelongsTo
    {
        return $this->belongsTo(SaleDetail::class);
    }

    public function medicineBatch(): BelongsTo
    {
        return $this->belongsTo(MedicineBatch::class);
    }
}
