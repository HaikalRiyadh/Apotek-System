<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    /**
     * Create a purchase with details, batches)and update stock.
     */
    public function createPurchase(array $data, array $items): Purchase
    {
        return DB::transaction(function () use ($data, $items) {
            // Create purchase
            $purchase = Purchase::create([
                'invoice_number' => Purchase::generateInvoiceNumber(),
                'supplier_id' => $data['supplier_id'],
                'user_id' => auth()->id(),
                'purchase_date' => $data['purchase_date'],
                'notes' => $data['notes'] ?? null,
                'status' => 'completed',
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            foreach ($items as $item) {
                $subtotal = $item['quantity'] * $item['purchase_price'];
                $totalAmount += $subtotal;

                // Create purchase detail
                $detail = $this->createPurchaseDetail($purchase, $item, $subtotal);

                // Create batch
                $this->createBatch($detail, $item);

                // Increase stock
                $this->increaseStock($item['medicine_id'], $item['quantity']);
            }

            $purchase->update(['total_amount' => $totalAmount]);

            return $purchase->load('details.medicine', 'supplier');
        });
    }

    protected function createPurchaseDetail(Purchase $purchase, array $item, float $subtotal): PurchaseDetail
    {
        return PurchaseDetail::create([
            'purchase_id' => $purchase->id,
            'medicine_id' => $item['medicine_id'],
            'quantity' => $item['quantity'],
            'purchase_price' => $item['purchase_price'],
            'subtotal' => $subtotal,
            'batch_number' => $item['batch_number'],
            'expired_date' => $item['expired_date'],
        ]);
    }

    protected function createBatch(PurchaseDetail $detail, array $item): MedicineBatch
    {
        return MedicineBatch::create([
            'medicine_id' => $item['medicine_id'],
            'batch_number' => $item['batch_number'],
            'expired_date' => $item['expired_date'],
            'purchase_price' => $item['purchase_price'],
            'initial_quantity' => $item['quantity'],
            'remaining_quantity' => $item['quantity'],
            'purchase_detail_id' => $detail->id,
        ]);
    }

    protected function increaseStock(int $medicineId, int $quantity): void
    {
        $medicine = Medicine::findOrFail($medicineId);
        $medicine->increment('stock_total', $quantity);
    }
}
