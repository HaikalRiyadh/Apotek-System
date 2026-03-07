<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model name without namespace
     */
    public function getModelNameAttribute(): string
    {
        return class_basename($this->model_type);
    }

    /**
     * Get action badge color
     */
    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get action label in Indonesian
     */
    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'created' => 'Tambah',
            'updated' => 'Ubah',
            'deleted' => 'Hapus',
            default => $this->action,
        };
    }

    /**
     * Log an activity
     */
    public static function log(
        string $action,
        ?object $model = null,
        string $description = '',
        ?array $oldValues = null,
        ?array $newValues = null
    ): self {
        return static::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id ?? $model?->getKey(),
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
