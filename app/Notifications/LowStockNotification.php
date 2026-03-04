<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    public function __construct(protected array $medicines) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'low_stock',
            'title' => 'Peringatan Stok Rendah',
            'message' => count($this->medicines) . ' obat memiliki stok di bawah minimum.',
            'medicines' => $this->medicines,
        ];
    }
}
