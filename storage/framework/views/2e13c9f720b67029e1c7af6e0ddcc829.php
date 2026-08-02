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
        <h2 class="text-xl font-bold text-slate-800">Laporan Pembelian</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Rekap data pembelian berdasarkan periode</p>
            <button onclick="window.print()" class="btn-secondary print:hidden">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </button>
        </div>

            
            <div class="card print:hidden">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('reports.purchases')); ?>" class="flex flex-wrap items-end gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-slate-600 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date"
                                   value="<?php echo e(request('start_date', now()->startOfMonth()->toDateString())); ?>"
                                   class="bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-slate-600 mb-1">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date"
                                   value="<?php echo e(request('end_date', now()->toDateString())); ?>"
                                   class="bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div>
                            <button type="submit" class="btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Pembelian</p>
                        <p class="text-3xl font-bold mt-1">Rp <?php echo e(number_format($totalPurchases, 0, ',', '.')); ?></p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                </div>
            </div>

            
            <div class="card">
                <div class="overflow-x-auto">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Supplier</th>
                                <th>Tanggal</th>
                                <th class="text-right">Total</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-slate-400"><?php echo e($index + 1); ?></td>
                                    <td class="font-semibold text-emerald-600"><?php echo e($purchase->invoice_number); ?></td>
                                    <td><?php echo e($purchase->supplier->name ?? '-'); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y')); ?></td>
                                    <td class="text-right font-semibold">Rp <?php echo e(number_format($purchase->total_amount, 0, ',', '.')); ?></td>
                                    <td><?php echo e($purchase->user->name ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-slate-400">Tidak ada data pembelian.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/reports/purchases.blade.php ENDPATH**/ ?>