<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExpiringMedicineNotification extends Notification
{
    use Queueable;

    public function __construct(protected array $batches) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'expiring_medicine',
            'title' => 'Peringatan Obat Mendekati Expired',
            'message' => count($this->batches) . ' batch obat akan expired dalam 30 hari.',
            'batches' => $this->batches,
        ];
    }
}
