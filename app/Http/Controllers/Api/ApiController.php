<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(protected ReportService $reportService) {}

    /**
     * Dashboard Statistics
     */
    public function dashboardStats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'sales_today' => $this->reportService->salesToday(),
                'sales_this_month' => $this->reportService->salesThisMonth(),
                'purchases_this_month' => $this->reportService->purchasesThisMonth(),
                'total_medicines' => $this->reportService->totalMedicines(),
                'total_suppliers' => $this->reportService->totalSuppliers(),
                'low_stock_count' => $this->reportService->lowStockMedicines()->count(),
                'expiring_count' => $this->reportService->expiringMedicines(30)->count(),
                'gross_profit_this_month' => $this->reportService->grossProfitThisMonth(),
                'sales_count_today' => $this->reportService->salesCountToday(),
            ],
        ]);
    }

    /**
     * List Medicines with search, filter, and pagination
     */
    public function medicines(Request $request): JsonResponse
    {
        $query = Medicine::with('category:id,name', 'unit:id,name,abbreviation');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $perPage = min($request->get('per_page', 15), 100);
        $medicines = $query->orderBy('name')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $medicines->items(),
            'meta' => [
                'current_page' => $medicines->currentPage(),
                'last_page' => $medicines->lastPage(),
                'per_page' => $medicines->perPage(),
                'total' => $medicines->total(),
            ],
        ]);
    }

    /**
     * Medicine Detail with batches
     */
    public function medicineDetail(Medicine $medicine): JsonResponse
    {
        $medicine->load('category:id,name', 'unit:id,name,abbreviation', 'batches');

        return response()->json([
            'success' => true,
            'data' => $medicine,
        ]);
    }

    /**
     * Low Stock Medicines
     */
    public function lowStock(): JsonResponse
    {
        $medicines = $this->reportService->lowStockMedicines();

        return response()->json([
            'success' => true,
            'data' => $medicines,
            'count' => $medicines->count(),
        ]);
    }

    /**
     * Expiring Medicines
     */
    public function expiring(Request $request): JsonResponse
    {
        $days = $request->get('days', 30);
        $expiring = $this->reportService->expiringMedicines($days);
        $expired = $this->reportService->expiredMedicines();

        return response()->json([
            'success' => true,
            'data' => [
                'expiring' => $expiring,
                'expired' => $expired,
            ],
            'count' => [
                'expiring' => $expiring->count(),
                'expired' => $expired->count(),
            ],
        ]);
    }

    /**
     * List Sales
     */
    public function sales(Request $request): JsonResponse
    {
        $query = Sale::with('user:id,name');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('sale_date', '>=', $request->start_date)
                  ->whereDate('sale_date', '<=', $request->end_date);
        }

        $perPage = min($request->get('per_page', 15), 100);
        $sales = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $sales->items(),
            'meta' => [
                'current_page' => $sales->currentPage(),
                'last_page' => $sales->lastPage(),
                'per_page' => $sales->perPage(),
                'total' => $sales->total(),
            ],
        ]);
    }

    /**
     * Sale Detail
     */
    public function saleDetail(Sale $sale): JsonResponse
    {
        $sale->load('details.medicine.unit', 'user:id,name');

        return response()->json([
            'success' => true,
            'data' => $sale,
        ]);
    }

    /**
     * List Purchases
     */
    public function purchases(Request $request): JsonResponse
    {
        $query = Purchase::with('supplier:id,name', 'user:id,name');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('purchase_date', '>=', $request->start_date)
                  ->whereDate('purchase_date', '<=', $request->end_date);
        }

        $perPage = min($request->get('per_page', 15), 100);
        $purchases = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $purchases->items(),
            'meta' => [
                'current_page' => $purchases->currentPage(),
                'last_page' => $purchases->lastPage(),
                'per_page' => $purchases->perPage(),
                'total' => $purchases->total(),
            ],
        ]);
    }

    /**
     * Purchase Detail
     */
    public function purchaseDetail(Purchase $purchase): JsonResponse
    {
        $purchase->load('details.medicine.unit', 'supplier', 'user:id,name');

        return response()->json([
            'success' => true,
            'data' => $purchase,
        ]);
    }

    /**
     * List Categories
     */
    public function categories(): JsonResponse
    {
        $categories = Category::withCount('medicines')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * List Suppliers
     */
    public function suppliers(): JsonResponse
    {
        $suppliers = Supplier::withCount('purchases')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $suppliers,
        ]);
    }

    /**
     * Sales Report
     */
    public function reportSales(Request $request): JsonResponse
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        $sales = $this->reportService->salesReport($startDate, $endDate);

        return response()->json([
            'success' => true,
            'data' => [
                'total_sales' => $sales->sum('grand_total'),
                'total_transactions' => $sales->count(),
                'sales' => $sales,
            ],
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
        ]);
    }

    /**
     * Stock Report
     */
    public function reportStock(): JsonResponse
    {
        $medicines = $this->reportService->stockReport();

        return response()->json([
            'success' => true,
            'data' => $medicines,
            'summary' => [
                'total_medicines' => $medicines->count(),
                'total_stock' => $medicines->sum('stock_total'),
                'low_stock_count' => $medicines->filter(fn($m) => $m->stock_total <= $m->minimum_stock)->count(),
            ],
        ]);
    }
}
