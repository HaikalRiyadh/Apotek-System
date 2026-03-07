<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected ReportService $reportService) {}

    public function index()
    {
        $salesToday = $this->reportService->salesToday();
        $salesMonth = $this->reportService->salesThisMonth();
        $topMedicines = $this->reportService->topSellingMedicines(5);
        $salesChart = $this->reportService->salesLast7Days();
        $lowStock = $this->reportService->lowStockMedicines();
        $expiring = $this->reportService->expiringMedicines(30);

        // Enhanced analytics
        $purchasesToday = $this->reportService->purchasesToday();
        $purchasesMonth = $this->reportService->purchasesThisMonth();
        $grossProfitMonth = $this->reportService->grossProfitThisMonth();
        $totalMedicines = $this->reportService->totalMedicines();
        $totalSuppliers = $this->reportService->totalSuppliers();
        $salesCountToday = $this->reportService->salesCountToday();
        $purchasesChart = $this->reportService->purchasesLast7Days();

        return view('dashboard', compact(
            'salesToday',
            'salesMonth',
            'topMedicines',
            'salesChart',
            'lowStock',
            'expiring',
            'purchasesToday',
            'purchasesMonth',
            'grossProfitMonth',
            'totalMedicines',
            'totalSuppliers',
            'salesCountToday',
            'purchasesChart'
        ));
    }
}
