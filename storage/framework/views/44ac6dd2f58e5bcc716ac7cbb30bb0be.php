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
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('medicines.index')); ?>" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Detail Obat</h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500"><?php echo e($medicine->name); ?></p>
            <a href="<?php echo e(route('medicines.edit', $medicine)); ?>" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>
        <!-- Medicine Info -->
        <div class="card">
            <div class="card-header"><h3 class="font-semibold text-slate-700">Informasi Obat</h3></div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Kode</span>
                        <p class="mt-1 text-sm font-semibold text-slate-700"><?php echo e($medicine->code); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Nama</span>
                        <p class="mt-1 text-sm font-semibold text-slate-700"><?php echo e($medicine->name); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Kategori</span>
                        <p class="mt-1"><span class="badge badge-info"><?php echo e($medicine->category->name ?? '-'); ?></span></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Satuan</span>
                        <p class="mt-1"><span class="badge badge-info"><?php echo e($medicine->unit->name ?? '-'); ?></span></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Harga Beli</span>
                        <p class="mt-1 text-sm font-semibold text-slate-700">Rp <?php echo e(number_format($medicine->default_purchase_price, 0, ',', '.')); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Harga Jual</span>
                        <p class="mt-1 text-sm font-semibold text-emerald-600">Rp <?php echo e(number_format($medicine->selling_price, 0, ',', '.')); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Stok Saat Ini</span>
                        <p class="mt-1 text-lg font-bold <?php echo e($medicine->stock <= $medicine->minimum_stock ? 'text-red-500' : 'text-emerald-600'); ?>"><?php echo e($medicine->stock); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Stok Minimum</span>
                        <p class="mt-1 text-sm font-semibold text-slate-700"><?php echo e($medicine->minimum_stock); ?></p>
                    </div>
                    <div class="md:col-span-2 lg:col-span-4">
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Deskripsi</span>
                        <p class="mt-1 text-sm text-slate-600"><?php echo e($medicine->description ?? '-'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Batches Table -->
        <div class="card">
            <div class="card-header"><h3 class="font-semibold text-slate-700">Daftar Batch</h3></div>
            <div class="overflow-x-auto">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th>No Batch</th>
                            <th>Expired</th>
                            <th class="text-right">Harga Beli</th>
                            <th class="text-right">Qty Awal</th>
                            <th class="text-right">Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $medicine->batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $expired = \Carbon\Carbon::parse($batch->expired_date);
                                $now = now();
                                $isExpired = $expired->isPast();
                                $isNearExpiry = !$isExpired && (int) $expired->diffInDays($now) <= 30;
                            ?>
                            <tr>
                                <td class="font-medium text-slate-700"><?php echo e($batch->batch_number); ?></td>
                                <td>
                                    <span class="<?php echo e($isExpired ? 'text-red-500' : ($isNearExpiry ? 'text-amber-500' : 'text-slate-600')); ?>"><?php echo e($expired->format('d/m/Y')); ?></span>
                                    <?php if($isExpired): ?><span class="badge badge-danger ml-1">Expired</span>
                                    <?php elseif($isNearExpiry): ?><span class="badge badge-warning ml-1">Segera Expired</span><?php endif; ?>
                                </td>
                                <td class="text-right text-slate-600">Rp <?php echo e(number_format($batch->purchase_price, 0, ',', '.')); ?></td>
                                <td class="text-right text-slate-500"><?php echo e($batch->initial_quantity); ?></td>
                                <td class="text-right font-bold text-slate-700"><?php echo e($batch->quantity); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="text-center py-8"><p class="text-sm text-slate-400">Belum ada batch untuk obat ini</p></td></tr>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/medicines/show.blade.php ENDPATH**/ ?>