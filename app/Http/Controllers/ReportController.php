<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService) {}

    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        $sales = $this->reportService->salesReport($startDate, $endDate);
        $totalSales = $sales->sum('grand_total');

        return view('reports.sales', compact('sales', 'startDate', 'endDate', 'totalSales'));
    }

    public function purchases(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        $purchases = $this->reportService->purchasesReport($startDate, $endDate);
        $totalPurchases = $purchases->sum('total_amount');

        return view('reports.purchases', compact('purchases', 'startDate', 'endDate', 'totalPurchases'));
    }

    public function stock()
    {
        $medicines = $this->reportService->stockReport();
        return view('reports.stock', compact('medicines'));
    }

    public function expiring(Request $request)
    {
        $days = $request->get('days', 30);
        $expiring = $this->reportService->expiringMedicines($days);
        $expired = $this->reportService->expiredMedicines();

        return view('reports.expiring', compact('expiring', 'expired', 'days'));
    }

    public function grossProfit(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        $report = $this->reportService->grossProfitReport($startDate, $endDate);

        return view('reports.gross-profit', compact('report', 'startDate', 'endDate'));
    }
}
