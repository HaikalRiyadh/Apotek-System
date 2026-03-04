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

        return view('dashboard', compact(
            'salesToday',
            'salesMonth',
            'topMedicines',
            'salesChart',
            'lowStock',
            'expiring'
        ));
    }
}
