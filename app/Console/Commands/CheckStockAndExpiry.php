<?php

namespace App\Console\Commands;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\User;
use App\Notifications\LowStockNotification;
use App\Notifications\ExpiringMedicineNotification;
use Illuminate\Console\Command;

class CheckStockAndExpiry extends Command
{
    protected $signature = 'pharmacy:check-alerts';
    protected $description = 'Check for low stock and expiring medicines and send notifications';

    public function handle(): int
    {
        $this->checkLowStock();
        $this->checkExpiring();

        $this->info('Pharmacy alerts checked successfully.');
        return Command::SUCCESS;
    }

    protected function checkLowStock(): void
    {
        $lowStock = Medicine::whereColumn('stock_total', '<=', 'minimum_stock')
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'name' => $m->name,
                'stock_total' => $m->stock_total,
                'minimum_stock' => $m->minimum_stock,
            ])
            ->toArray();

        if (count($lowStock) > 0) {
            $admins = User::role('Admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new LowStockNotification($lowStock));
            }
            $this->info(count($lowStock) . ' obat stok rendah.');
        }
    }

    protected function checkExpiring(): void
    {
        $expiring = MedicineBatch::with('medicine')
            ->where('remaining_quantity', '>', 0)
            ->where('expired_date', '<=', now()->addDays(30))
            ->where('expired_date', '>', now())
            ->get()
            ->map(fn($b) => [
                'id' => $b->id,
                'medicine_name' => $b->medicine->name,
                'batch_number' => $b->batch_number,
                'expired_date' => $b->expired_date->format('Y-m-d'),
                'remaining_quantity' => $b->remaining_quantity,
            ])
            ->toArray();

        if (count($expiring) > 0) {
            $admins = User::role('Admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new ExpiringMedicineNotification($expiring));
            }
            $this->info(count($expiring) . ' batch mendekati expired.');
        }
    }
}
