<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportService
{
    public function salesToday(): float
    {
        return Sale::whereDate('sale_date', today())->sum('grand_total');
    }

    public function salesThisMonth(): float
    {
        return Sale::whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->sum('grand_total');
    }

    public function topSellingMedicines(int $limit = 5): array
    {
        return SaleDetail::select('medicine_id', DB::raw('SUM(quantity) as total_qty'))
            ->with('medicine:id,name')
            ->groupBy('medicine_id')
            ->orderByDesc('total_qty')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function salesLast7Days(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $total = Sale::whereDate('sale_date', $date)->sum('grand_total');
            $data[] = [
                'date' => $date->format('d M'),
                'total' => (float) $total,
            ];
        }
        return $data;
    }

    public function salesReport(string $startDate, string $endDate)
    {
        return Sale::with('details.medicine', 'user')
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->orderBy('sale_date', 'desc')
            ->get();
    }

    public function purchasesReport(string $startDate, string $endDate)
    {
        return Purchase::with('details.medicine', 'supplier', 'user')
            ->whereDate('purchase_date', '>=', $startDate)
            ->whereDate('purchase_date', '<=', $endDate)
            ->orderBy('purchase_date', 'desc')
            ->get();
    }

    public function stockReport()
    {
        return Medicine::with('category', 'unit')
            ->orderBy('name')
            ->get();
    }

    public function expiringMedicines(int $days = 30)
    {
        return MedicineBatch::with('medicine.unit')
            ->where('remaining_quantity', '>', 0)
            ->where('expired_date', '<=', now()->addDays($days))
            ->where('expired_date', '>', now())
            ->orderBy('expired_date')
            ->get();
    }

    public function expiredMedicines()
    {
        return MedicineBatch::with('medicine.unit')
            ->where('remaining_quantity', '>', 0)
            ->where('expired_date', '<=', now())
            ->orderBy('expired_date')
            ->get();
    }

    /**
     * Laba kotor dihitung berdasarkan harga beli batch (bukan default).
     * Laba = (harga_jual - harga_beli_batch_avg) * qty
     */
    public function grossProfitReport(string $startDate, string $endDate)
    {
        $sales = Sale::with('details.medicine')
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->orderBy('sale_date', 'desc')
            ->get();

        $totalRevenue = 0;
        $totalCost = 0;

        foreach ($sales as $sale) {
            foreach ($sale->details as $detail) {
                $totalRevenue += $detail->selling_price * $detail->quantity;
                $totalCost += $detail->purchase_price_avg * $detail->quantity;
            }
        }

        return [
            'sales' => $sales,
            'total_revenue' => $totalRevenue,
            'total_cost' => $totalCost,
            'gross_profit' => $totalRevenue - $totalCost,
        ];
    }

    public function lowStockMedicines()
    {
        return Medicine::with('category', 'unit')
            ->whereColumn('stock_total', '<=', 'minimum_stock')
            ->orderBy('stock_total')
            ->get();
    }

    public function purchasesToday(): float
    {
        return Purchase::whereDate('purchase_date', today())->sum('total_amount');
    }

    public function purchasesThisMonth(): float
    {
        return Purchase::whereMonth('purchase_date', now()->month)
            ->whereYear('purchase_date', now()->year)
            ->sum('total_amount');
    }

    public function grossProfitThisMonth(): float
    {
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->toDateString();
        $report = $this->grossProfitReport($startDate, $endDate);
        return $report['gross_profit'];
    }

    public function totalMedicines(): int
    {
        return Medicine::count();
    }

    public function totalSuppliers(): int
    {
        return Supplier::count();
    }

    public function salesCountToday(): int
    {
        return Sale::whereDate('sale_date', today())->count();
    }

    public function purchasesLast7Days(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $total = Purchase::whereDate('purchase_date', $date)->sum('total_amount');
            $data[] = [
                'date' => $date->format('d M'),
                'total' => (float) $total,
            ];
        }
        return $data;
    }

    public function monthlySalesComparison(): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $total = Sale::whereMonth('sale_date', $date->month)
                ->whereYear('sale_date', $date->year)
                ->sum('grand_total');
            $data[] = [
                'month' => $date->format('M Y'),
                'total' => (float) $total,
            ];
        }
        return $data;
    }

    public function categorySalesDistribution(): array
    {
        return DB::table('sale_details')
            ->join('medicines', 'sale_details.medicine_id', '=', 'medicines.id')
            ->join('categories', 'medicines.category_id', '=', 'categories.id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereMonth('sales.sale_date', now()->month)
            ->whereYear('sales.sale_date', now()->year)
            ->select('categories.name', DB::raw('SUM(sale_details.subtotal) as total'))
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get()
            ->toArray();
    }
}
