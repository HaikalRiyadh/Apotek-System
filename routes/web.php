<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Categories
    Route::resource('categories', CategoryController::class)->except('show')
        ->middleware('permission:manage categories');

    // Units
    Route::resource('units', UnitController::class)->except('show')
        ->middleware('permission:manage units');

    // Medicines
    Route::resource('medicines', MedicineController::class)
        ->middleware('permission:view medicines');

    // API: Medicine search for POS
    Route::get('/api/medicines/search', [MedicineController::class, 'search'])
        ->name('medicines.search');

    // Suppliers
    Route::resource('suppliers', SupplierController::class)->except('show')
        ->middleware('permission:view suppliers');

    // Purchases
    Route::get('/purchases', [PurchaseController::class, 'index'])
        ->name('purchases.index')->middleware('permission:view purchases');
    Route::get('/purchases/create', [PurchaseController::class, 'create'])
        ->name('purchases.create')->middleware('permission:create purchases');
    Route::post('/purchases', [PurchaseController::class, 'store'])
        ->name('purchases.store')->middleware('permission:create purchases');
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])
        ->name('purchases.show')->middleware('permission:view purchases');

    // Sales
    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index')->middleware('permission:view sales');
    Route::get('/sales/create', [SaleController::class, 'create'])
        ->name('sales.create')->middleware('permission:create sales');
    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store')->middleware('permission:create sales');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])
        ->name('sales.show')->middleware('permission:view sales');

    // Reports
    Route::middleware('permission:view reports')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/purchases', [ReportController::class, 'purchases'])->name('purchases');
        Route::get('/stock', [ReportController::class, 'stock'])->name('stock');
        Route::get('/expiring', [ReportController::class, 'expiring'])->name('expiring');
        Route::get('/gross-profit', [ReportController::class, 'grossProfit'])->name('gross-profit');
    });

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // Activity Logs (Admin only)
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
        ->name('activity-logs.index')
        ->middleware('role:Admin');

    // Stock Adjustments
    Route::middleware('permission:edit medicines')->group(function () {
        Route::get('/stock-adjustments', [StockAdjustmentController::class, 'index'])->name('stock-adjustments.index');
        Route::get('/stock-adjustments/create', [StockAdjustmentController::class, 'create'])->name('stock-adjustments.create');
        Route::post('/stock-adjustments', [StockAdjustmentController::class, 'store'])->name('stock-adjustments.store');
        Route::get('/stock-adjustments/dispose-expired', [StockAdjustmentController::class, 'disposeExpired'])->name('stock-adjustments.dispose-expired');
        Route::post('/stock-adjustments/dispose-expired', [StockAdjustmentController::class, 'disposeExpiredStore'])->name('stock-adjustments.dispose-expired.store');
        Route::get('/stock-adjustments/batches/{medicine}', [StockAdjustmentController::class, 'getBatches'])->name('stock-adjustments.batches');
    });
});

require __DIR__.'/auth.php';
