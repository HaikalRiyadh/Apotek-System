<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $modelName = class_basename($model);
            $name = $model->name ?? $model->invoice_number ?? $model->code ?? "#{$model->id}";
            ActivityLog::log(
                'created',
                $model,
                "{$modelName} \"{$name}\" berhasil ditambahkan.",
                null,
                $model->getAttributes()
            );
        });

        static::updated(function ($model) {
            $modelName = class_basename($model);
            $name = $model->name ?? $model->invoice_number ?? $model->code ?? "#{$model->id}";
            $original = $model->getOriginal();
            $changes = $model->getChanges();

            // Remove timestamps from change tracking
            unset($changes['updated_at'], $changes['created_at']);
            unset($original['updated_at'], $original['created_at']);

            if (empty($changes)) {
                return;
            }

            // Only log fields that actually changed
            $oldValues = array_intersect_key($original, $changes);

            ActivityLog::log(
                'updated',
                $model,
                "{$modelName} \"{$name}\" berhasil diperbarui.",
                $oldValues,
                $changes
            );
        });

        static::deleted(function ($model) {
            $modelName = class_basename($model);
            $name = $model->name ?? $model->invoice_number ?? $model->code ?? "#{$model->id}";
            ActivityLog::log(
                'deleted',
                $model,
                "{$modelName} \"{$name}\" berhasil dihapus.",
                $model->getAttributes(),
                null
            );
        });
    }
}
