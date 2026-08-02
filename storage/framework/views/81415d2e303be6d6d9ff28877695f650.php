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
        <h2 class="text-xl font-bold text-slate-800">Laporan Stok</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Daftar stok seluruh obat saat ini</p>
            <button onclick="window.print()" class="btn-secondary print:hidden">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </button>
        </div>

            <div class="card">
                <div class="overflow-x-auto">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Obat</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th class="text-right">Harga Beli</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Min Stok</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-slate-400"><?php echo e($index + 1); ?></td>
                                    <td class="font-semibold text-emerald-600"><?php echo e($medicine->code); ?></td>
                                    <td class="font-medium"><?php echo e($medicine->name); ?></td>
                                    <td><?php echo e($medicine->category->name ?? '-'); ?></td>
                                    <td><?php echo e($medicine->unit->name ?? '-'); ?></td>
                                    <td class="text-right">Rp <?php echo e(number_format($medicine->purchase_price, 0, ',', '.')); ?></td>
                                    <td class="text-right">Rp <?php echo e(number_format($medicine->selling_price, 0, ',', '.')); ?></td>
                                    <td class="text-center font-semibold"><?php echo e($medicine->stock_total); ?></td>
                                    <td class="text-center text-slate-400"><?php echo e($medicine->minimum_stock); ?></td>
                                    <td class="text-center">
                                        <?php if($medicine->stock_total <= $medicine->minimum_stock): ?>
                                            <span class="badge badge-danger">Rendah</span>
                                        <?php else: ?>
                                            <span class="badge badge-success">Normal</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="10" class="text-center py-8 text-slate-400">Tidak ada data obat.</td>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/reports/stock.blade.php ENDPATH**/ ?>