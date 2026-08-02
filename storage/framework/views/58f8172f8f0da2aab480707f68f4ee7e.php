<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="text-xl font-bold text-slate-800">Dashboard</h2>
     <?php $__env->endSlot(); ?>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs text-slate-400 font-medium"><?php echo e($salesCountToday); ?> transaksi</span>
                </div>
                <div class="text-2xl font-extrabold text-slate-800">Rp <?php echo e(number_format($salesToday, 0, ',', '.')); ?></div>
                <div class="text-xs text-slate-500 mt-1 font-medium">Penjualan Hari Ini</div>
            </div>

            
            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span class="badge badge-info">Bulan Ini</span>
                </div>
                <div class="text-2xl font-extrabold text-slate-800">Rp <?php echo e(number_format($salesMonth, 0, ',', '.')); ?></div>
                <div class="text-xs text-slate-500 mt-1 font-medium">Pembelian: Rp <?php echo e(number_format($purchasesMonth, 0, ',', '.')); ?></div>
            </div>

            
            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg shadow-violet-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <span class="badge badge-success">Profit</span>
                </div>
                <div class="text-2xl font-extrabold text-slate-800">Rp <?php echo e(number_format($grossProfitMonth, 0, ',', '.')); ?></div>
                <div class="text-xs text-slate-500 mt-1 font-medium"><?php echo e($totalMedicines); ?> obat &middot; <?php echo e($totalSuppliers); ?> supplier</div>
            </div>

            
            <div class="stat-card <?php echo e(($lowStock->count() > 0 || $expiring->count() > 0) ? 'ring-1 ring-red-100' : ''); ?>">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon bg-gradient-to-br from-red-500 to-rose-600 shadow-lg shadow-red-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <?php if($lowStock->count() > 0 || $expiring->count() > 0): ?>
                        <span class="badge badge-danger">Perhatian</span>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-5">
                    <div>
                        <div class="text-2xl font-extrabold <?php echo e($lowStock->count() > 0 ? 'text-red-600' : 'text-slate-800'); ?>"><?php echo e($lowStock->count()); ?></div>
                        <div class="text-xs text-slate-500 font-medium">Stok Rendah</div>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div>
                        <div class="text-2xl font-extrabold <?php echo e($expiring->count() > 0 ? 'text-amber-600' : 'text-slate-800'); ?>"><?php echo e($expiring->count()); ?></div>
                        <div class="text-xs text-slate-500 font-medium">Hampir Expired</div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            
            <div class="lg:col-span-2 card">
                <div class="card-header">
                    <h3 class="text-sm font-bold text-slate-700">Penjualan & Pembelian 7 Hari Terakhir</h3>
                    <span class="badge badge-info">Mingguan</span>
                </div>
                <div class="card-body">
                    <canvas id="salesPurchasesChart" height="140"></canvas>
                </div>
            </div>

            
            <div class="card">
                <div class="card-header">
                    <h3 class="text-sm font-bold text-slate-700">Top 5 Obat Terlaris</h3>
                    <span class="badge badge-success">Terbaik</span>
                </div>
                <div class="card-body">
                    <canvas id="topMedicinesChart" height="200"></canvas>
                </div>
            </div>
        </div>

        
        <?php if($lowStock->count() > 0 || $expiring->count() > 0): ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <?php if($lowStock->count() > 0): ?>
            <div x-data="{ open: true }" class="card">
                <button @click="open = !open" class="w-full card-header hover:bg-slate-50/50 transition-colors cursor-pointer">
                    <h3 class="text-sm font-bold text-red-600 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        Stok Rendah
                        <span class="badge badge-danger"><?php echo e($lowStock->count()); ?></span>
                    </h3>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse>
                    <div class="overflow-x-auto">
                        <table class="pro-table">
                            <thead>
                                <tr>
                                    <th>Obat</th>
                                    <th class="text-right">Stok</th>
                                    <th class="text-right">Minimum</th>
                                    <th class="text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lowStock->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="font-medium text-slate-700"><?php echo e($med->name); ?></td>
                                    <td class="text-right font-bold <?php echo e($med->stock_total == 0 ? 'text-red-600' : 'text-amber-600'); ?>"><?php echo e($med->stock_total); ?></td>
                                    <td class="text-right text-slate-400"><?php echo e($med->minimum_stock); ?></td>
                                    <td class="text-right">
                                        <?php if($med->stock_total == 0): ?>
                                            <span class="badge badge-danger">Habis</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Rendah</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($lowStock->count() > 10): ?>
                        <div class="px-5 py-3 text-xs text-slate-400 border-t border-slate-100">dan <?php echo e($lowStock->count() - 10); ?> obat lainnya...</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if($expiring->count() > 0): ?>
            <div x-data="{ open: true }" class="card">
                <button @click="open = !open" class="w-full card-header hover:bg-slate-50/50 transition-colors cursor-pointer">
                    <h3 class="text-sm font-bold text-amber-600 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Mendekati Expired
                        <span class="badge badge-warning"><?php echo e($expiring->count()); ?></span>
                    </h3>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse>
                    <div class="overflow-x-auto">
                        <table class="pro-table">
                            <thead>
                                <tr>
                                    <th>Obat</th>
                                    <th>Batch</th>
                                    <th class="text-right">Sisa</th>
                                    <th class="text-right">Expired</th>
                                    <th class="text-right">Sisa Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $expiring->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="font-medium text-slate-700"><?php echo e($batch->medicine->name); ?></td>
                                    <td class="text-slate-400 text-xs font-mono"><?php echo e($batch->batch_number); ?></td>
                                    <td class="text-right text-slate-600"><?php echo e($batch->remaining_quantity); ?></td>
                                    <td class="text-right text-slate-400"><?php echo e($batch->expired_date->format('d/m/Y')); ?></td>
                                    <td class="text-right">
                                        <?php $daysLeft = (int) now()->diffInDays($batch->expired_date, false); ?>
                                        <span class="badge <?php echo e($daysLeft <= 7 ? 'badge-danger' : 'badge-warning'); ?>">
                                            <?php echo e($daysLeft); ?> hari
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($expiring->count() > 10): ?>
                        <div class="px-5 py-3 text-xs text-slate-400 border-t border-slate-100">dan <?php echo e($expiring->count() - 10); ?> batch lainnya...</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#94a3b8';

        const palette = ['rgba(16,185,129,0.85)','rgba(59,130,246,0.85)','rgba(245,158,11,0.85)','rgba(239,68,68,0.85)','rgba(139,92,246,0.85)','rgba(6,182,212,0.85)','rgba(244,63,94,0.85)','rgba(34,197,94,0.85)'];

        const salesData = <?php echo json_encode($salesChart, 15, 512) ?>;
        const purchasesData = <?php echo json_encode($purchasesChart, 15, 512) ?>;
        new Chart(document.getElementById('salesPurchasesChart'), {
            type: 'line',
            data: {
                labels: salesData.map(d => d.date),
                datasets: [
                    {
                        label: 'Penjualan',
                        data: salesData.map(d => d.total),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.06)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(16, 185, 129)',
                        borderWidth: 2.5,
                    },
                    {
                        label: 'Pembelian',
                        data: purchasesData.map(d => d.total),
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.06)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(99, 102, 241)',
                        borderWidth: 2.5,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { boxWidth: 8, usePointStyle: true, pointStyle: 'circle', padding: 20, font: { size: 12, weight: '600' } } } },
                scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false }, ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'rb', font: { size: 11 } } }, x: { grid: { display: false }, ticks: { font: { size: 11 } } } }
            }
        });

        const topData = <?php echo json_encode($topMedicines, 15, 512) ?>;
        new Chart(document.getElementById('topMedicinesChart'), {
            type: 'bar',
            data: {
                labels: topData.map(d => d.medicine ? d.medicine.name : 'N/A'),
                datasets: [{
                    data: topData.map(d => parseInt(d.total_qty)),
                    backgroundColor: palette,
                    borderRadius: 8,
                    maxBarThickness: 24,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false }, ticks: { font: { size: 11 } } }, y: { grid: { display: false }, ticks: { font: { size: 11, weight: '500' } } } }
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/dashboard.blade.php ENDPATH**/ ?>