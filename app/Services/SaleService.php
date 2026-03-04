<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleDetailBatch;
use Illuminate\Support\Facades\DB;

class SaleService
{
    /**
     * Create a sale with FIFO batch consumption.
     */
    public function createSale(array $data, array $items): Sale
    {
        return DB::transaction(function () use ($data, $items) {
            $subtotal = 0;

            // Validate stock availability first
            foreach ($items as $item) {
                $medicine = Medicine::findOrFail($item['medicine_id']);
                if ($medicine->stock_total < $item['quantity']) {
                    throw new \Exception("Stok {$medicine->name} tidak mencukupi. Tersedia: {$medicine->stock_total}");
                }
            }

            $sale = Sale::create([
                'invoice_number' => Sale::generateInvoiceNumber(),
                'user_id' => auth()->id(),
                'sale_date' => $data['sale_date'] ?? now()->toDateString(),
                'subtotal' => 0,
                'discount' => $data['discount'] ?? 0,
                'tax' => $data['tax'] ?? 0,
                'grand_total' => 0,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'amount_paid' => $data['amount_paid'] ?? 0,
                'change_amount' => 0,
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                $itemSubtotal = $item['quantity'] * $item['selling_price'];
                $subtotal += $itemSubtotal;

                // FIFO: consume batches by expired_date ascending
                $purchasePriceAvg = $this->consumeBatchesFIFO(
                    $sale,
                    $item['medicine_id'],
                    $item['quantity'],
                    $item['selling_price'],
                    $itemSubtotal
                );
            }

            $discount = $data['discount'] ?? 0;
            $tax = $data['tax'] ?? 0;
            $grandTotal = $subtotal - $discount + $tax;
            $amountPaid = $data['amount_paid'] ?? $grandTotal;
            $change = $amountPaid - $grandTotal;

            $sale->update([
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'amount_paid' => $amountPaid,
                'change_amount' => max(0, $change),
            ]);

            return $sale->load('details.medicine');
        });
    }

    /**
     * FIFO batch consumption: take from batches with earliest expiry first.
     */
    protected function consumeBatchesFIFO(
        Sale $sale,
        int $medicineId,
        int $quantity,
        float $sellingPrice,
        float $itemSubtotal
    ): float {
        $medicine = Medicine::findOrFail($medicineId);
        $batches = MedicineBatch::where('medicine_id', $medicineId)
            ->where('remaining_quantity', '>', 0)
            ->orderBy('expired_date', 'asc') // FIFO by expiry
            ->get();

        $remaining = $quantity;
        $totalPurchaseCost = 0;
        $batchRecords = [];

        foreach ($batches as $batch) {
            if ($remaining <= 0) break;

            $take = min($remaining, $batch->remaining_quantity);
            $totalPurchaseCost += $take * $batch->purchase_price;

            $batch->decrement('remaining_quantity', $take);
            $remaining -= $take;

            $batchRecords[] = [
                'batch' => $batch,
                'quantity_taken' => $take,
                'purchase_price' => $batch->purchase_price,
            ];
        }

        if ($remaining > 0) {
            throw new \Exception("Stok batch {$medicine->name} tidak mencukupi.");
        }

        $purchasePriceAvg = $totalPurchaseCost / $quantity;

        // Create sale detail
        $saleDetail = SaleDetail::create([
            'sale_id' => $sale->id,
            'medicine_id' => $medicineId,
            'quantity' => $quantity,
            'selling_price' => $sellingPrice,
            'purchase_price_avg' => $purchasePriceAvg,
            'subtotal' => $itemSubtotal,
        ]);

        // Record which batches were used
        foreach ($batchRecords as $record) {
            SaleDetailBatch::create([
                'sale_detail_id' => $saleDetail->id,
                'medicine_batch_id' => $record['batch']->id,
                'quantity_taken' => $record['quantity_taken'],
                'purchase_price' => $record['purchase_price'],
            ]);
        }

        // Update medicine stock
        $medicine->decrement('stock_total', $quantity);

        return $purchasePriceAvg;
    }
}
