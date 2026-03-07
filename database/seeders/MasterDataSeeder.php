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

        // Batch data per medicine: [batch_a_expired_days, batch_a_qty, batch_b_expired_days, batch_b_qty]
        // Negative days = already expired, positive = days from now
        $batchConfigs = [
            ['a_days' => 365,  'a_qty' => 150, 'b_days' => 13,   'b_qty' => 80],   // MED001: B mendekati expired
            ['a_days' => 300,  'a_qty' => 100, 'b_days' => -7,   'b_qty' => 40],   // MED002: B sudah expired
            ['a_days' => 270,  'a_qty' => 120, 'b_days' => 23,   'b_qty' => 60],   // MED003: B mendekati expired
            ['a_days' => 330,  'a_qty' => 100, 'b_days' => 25,   'b_qty' => 50],   // MED004: B mendekati expired
            ['a_days' => 540,  'a_qty' => 200, 'b_days' => 3,    'b_qty' => 90],   // MED005: B sangat dekat expired
            ['a_days' => 180,  'a_qty' => 50,  'b_days' => -20,  'b_qty' => 30],   // MED006: B sudah expired
            ['a_days' => 420,  'a_qty' => 150, 'b_days' => 18,   'b_qty' => 70],   // MED007: B mendekati expired
            ['a_days' => 240,  'a_qty' => 60,  'b_days' => -35,  'b_qty' => 25],   // MED008: B sudah expired
            ['a_days' => 450,  'a_qty' => 100, 'b_days' => 29,   'b_qty' => 50],   // MED009: B mendekati expired
            ['a_days' => 210,  'a_qty' => 80,  'b_days' => 7,    'b_qty' => 45],   // MED010: B sangat dekat expired
        ];

        foreach ($medicines as $index => $med) {
            $medicine = Medicine::create(array_merge($med, ['stock_total' => 0]));
            $config = $batchConfigs[$index];

            MedicineBatch::create([
                'medicine_id' => $medicine->id,
                'batch_number' => 'BATCH-' . $medicine->code . '-A',
                'expired_date' => now()->addDays($config['a_days'])->startOfDay(),
                'purchase_price' => $med['default_purchase_price'],
                'initial_quantity' => $config['a_qty'],
                'remaining_quantity' => $config['a_qty'],
            ]);

            MedicineBatch::create([
                'medicine_id' => $medicine->id,
                'batch_number' => 'BATCH-' . $medicine->code . '-B',
                'expired_date' => now()->addDays($config['b_days'])->startOfDay(),
                'purchase_price' => $med['default_purchase_price'] * 1.05,
                'initial_quantity' => $config['b_qty'],
                'remaining_quantity' => $config['b_qty'],
            ]);

            $medicine->update(['stock_total' => $config['a_qty'] + $config['b_qty']]);
        }
    }
}
