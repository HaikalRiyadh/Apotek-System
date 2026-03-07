<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API v1 routes for Apotek Kita Sehat.
| All routes require authentication via Sanctum.
|
*/

Route::middleware('auth:sanctum')->prefix('v1')->name('api.v1.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ApiController::class, 'dashboardStats'])->name('dashboard');

    // Medicines
    Route::get('/medicines', [ApiController::class, 'medicines'])->name('medicines.index');
    Route::get('/medicines/{medicine}', [ApiController::class, 'medicineDetail'])->name('medicines.show');

    // Alerts
    Route::get('/alerts/low-stock', [ApiController::class, 'lowStock'])->name('alerts.low-stock');
    Route::get('/alerts/expiring', [ApiController::class, 'expiring'])->name('alerts.expiring');

    // Sales
    Route::get('/sales', [ApiController::class, 'sales'])->name('sales.index');
    Route::get('/sales/{sale}', [ApiController::class, 'saleDetail'])->name('sales.show');

    // Purchases
    Route::get('/purchases', [ApiController::class, 'purchases'])->name('purchases.index');
    Route::get('/purchases/{purchase}', [ApiController::class, 'purchaseDetail'])->name('purchases.show');

    // Master Data
    Route::get('/categories', [ApiController::class, 'categories'])->name('categories.index');
    Route::get('/suppliers', [ApiController::class, 'suppliers'])->name('suppliers.index');

    // Reports
    Route::get('/reports/sales', [ApiController::class, 'reportSales'])->name('reports.sales');
    Route::get('/reports/stock', [ApiController::class, 'reportStock'])->name('reports.stock');
});
