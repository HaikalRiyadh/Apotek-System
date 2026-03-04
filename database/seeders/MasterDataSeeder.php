<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Unit;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Models\MedicineBatch;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $categories = [
            ['name' => 'Analgesik', 'description' => 'Obat pereda nyeri'],
            ['name' => 'Antibiotik', 'description' => 'Obat anti bakteri'],
            ['name' => 'Antipiretik', 'description' => 'Obat penurun panas'],
            ['name' => 'Antasida', 'description' => 'Obat maag'],
            ['name' => 'Vitamin', 'description' => 'Suplemen vitamin'],
            ['name' => 'Antiseptik', 'description' => 'Obat antiseptik'],
            ['name' => 'Antialergi', 'description' => 'Obat alergi'],
            ['name' => 'Obat Batuk', 'description' => 'Obat batuk dan pilek'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Units
        $units = [
            ['name' => 'Tablet', 'abbreviation' => 'tab'],
            ['name' => 'Kapsul', 'abbreviation' => 'kap'],
            ['name' => 'Botol', 'abbreviation' => 'btl'],
            ['name' => 'Strip', 'abbreviation' => 'str'],
            ['name' => 'Box', 'abbreviation' => 'box'],
            ['name' => 'Tube', 'abbreviation' => 'tube'],
            ['name' => 'Sachet', 'abbreviation' => 'sac'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }

        // Suppliers
        $suppliers = [
            ['name' => 'PT Kimia Farma', 'phone' => '021-1234567', 'email' => 'order@kimiafarma.co.id', 'address' => 'Jakarta', 'contact_person' => 'Budi Santoso'],
            ['name' => 'PT Kalbe Farma', 'phone' => '021-7654321', 'email' => 'order@kalbe.co.id', 'address' => 'Jakarta', 'contact_person' => 'Siti Rahayu'],
            ['name' => 'PT Sanbe Farma', 'phone' => '022-1234567', 'email' => 'order@sanbe.co.id', 'address' => 'Bandung', 'contact_person' => 'Ahmad Yani'],
        ];

        foreach ($suppliers as $sup) {
            Supplier::create($sup);
        }

        // Medicines with batches
        $medicines = [
            ['code' => 'MED001', 'name' => 'Paracetamol 500mg', 'category_id' => 1, 'unit_id' => 1, 'default_purchase_price' => 500, 'selling_price' => 1000, 'minimum_stock' => 100],
            ['code' => 'MED002', 'name' => 'Amoxicillin 500mg', 'category_id' => 2, 'unit_id' => 2, 'default_purchase_price' => 1500, 'selling_price' => 3000, 'minimum_stock' => 50],
            ['code' => 'MED003', 'name' => 'Ibuprofen 400mg', 'category_id' => 1, 'unit_id' => 1, 'default_purchase_price' => 800, 'selling_price' => 1500, 'minimum_stock' => 80],
            ['code' => 'MED004', 'name' => 'Antasida DOEN', 'category_id' => 4, 'unit_id' => 1, 'default_purchase_price' => 300, 'selling_price' => 700, 'minimum_stock' => 50],
            ['code' => 'MED005', 'name' => 'Vitamin C 500mg', 'category_id' => 5, 'unit_id' => 1, 'default_purchase_price' => 400, 'selling_price' => 800, 'minimum_stock' => 100],
            ['code' => 'MED006', 'name' => 'Betadine 30ml', 'category_id' => 6, 'unit_id' => 3, 'default_purchase_price' => 8000, 'selling_price' => 15000, 'minimum_stock' => 20],
            ['code' => 'MED007', 'name' => 'CTM 4mg', 'category_id' => 7, 'unit_id' => 1, 'default_purchase_price' => 200, 'selling_price' => 500, 'minimum_stock' => 100],
            ['code' => 'MED008', 'name' => 'OBH Combi Sirup', 'category_id' => 8, 'unit_id' => 3, 'default_purchase_price' => 12000, 'selling_price' => 22000, 'minimum_stock' => 30],
            ['code' => 'MED009', 'name' => 'Cefadroxil 500mg', 'category_id' => 2, 'unit_id' => 2, 'default_purchase_price' => 2000, 'selling_price' => 4000, 'minimum_stock' => 40],
            ['code' => 'MED010', 'name' => 'Omeprazole 20mg', 'category_id' => 4, 'unit_id' => 2, 'default_purchase_price' => 1200, 'selling_price' => 2500, 'minimum_stock' => 50],
        ];

        foreach ($medicines as $med) {
            $medicine = Medicine::create(array_merge($med, ['stock_total' => 0]));

            // Create 2 batches for each medicine
            $batch1Qty = rand(50, 200);
            $batch2Qty = rand(30, 150);

            MedicineBatch::create([
                'medicine_id' => $medicine->id,
                'batch_number' => 'BATCH-' . $medicine->code . '-A',
                'expired_date' => now()->addMonths(rand(6, 18)),
                'purchase_price' => $med['default_purchase_price'],
                'initial_quantity' => $batch1Qty,
                'remaining_quantity' => $batch1Qty,
            ]);

            MedicineBatch::create([
                'medicine_id' => $medicine->id,
                'batch_number' => 'BATCH-' . $medicine->code . '-B',
                'expired_date' => now()->addMonths(rand(1, 5)),
                'purchase_price' => $med['default_purchase_price'] * 1.05,
                'initial_quantity' => $batch2Qty,
                'remaining_quantity' => $batch2Qty,
            ]);

            $medicine->update(['stock_total' => $batch1Qty + $batch2Qty]);
        }
    }
}
