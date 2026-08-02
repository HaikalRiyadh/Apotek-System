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
        <h2 class="text-xl font-bold text-slate-800">Penyesuaian Stok</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Riwayat perubahan stok obat (buang expired, koreksi, retur)</p>
            <div class="flex gap-2">
                <a href="<?php echo e(route('stock-adjustments.dispose-expired')); ?>" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-xs font-semibold rounded-xl hover:bg-red-700 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Buang Obat Expired
                </a>
                <a href="<?php echo e(route('stock-adjustments.create')); ?>" class="btn-primary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Penyesuaian Baru
                </a>
            </div>
        </div>
            <?php if(session('success')): ?>
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-sm text-emerald-700 flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Filter -->
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('stock-adjustments.index')); ?>" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-48">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Cari Obat</label>
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Nama obat..."
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div class="w-44">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Tipe</label>
                            <select name="type" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">Semua</option>
                                <option value="dispose" <?php echo e(request('type') == 'dispose' ? 'selected' : ''); ?>>Buang/Expired</option>
                                <option value="correction" <?php echo e(request('type') == 'correction' ? 'selected' : ''); ?>>Koreksi Stok</option>
                                <option value="return" <?php echo e(request('type') == 'return' ? 'selected' : ''); ?>>Retur Supplier</option>
                                <option value="other" <?php echo e(request('type') == 'other' ? 'selected' : ''); ?>>Lainnya</option>
                            </select>
                        </div>
                        <div class="w-40">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div class="w-40">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="btn-primary">Filter</button>
                            <?php if(request()->hasAny(['search', 'type', 'start_date', 'end_date'])): ?>
                                <a href="<?php echo e(route('stock-adjustments.index')); ?>" class="btn-secondary">Reset</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card">
                <div class="overflow-x-auto">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Obat</th>
                                <th>Batch</th>
                                <th>Tipe</th>
                                <th class="text-center">Sebelum</th>
                                <th class="text-center">Dikurangi</th>
                                <th class="text-center">Sesudah</th>
                                <th>Alasan</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $adjustments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="whitespace-nowrap text-xs text-slate-400">
                                        <?php echo e($adj->created_at->format('d/m/Y H:i')); ?>

                                    </td>
                                    <td class="font-medium"><?php echo e($adj->medicine->name); ?></td>
                                    <td>
                                        <span class="badge badge-info"><?php echo e($adj->medicineBatch->batch_number); ?></span>
                                        <div class="text-xs text-slate-400 mt-0.5">Exp: <?php echo e($adj->medicineBatch->expired_date->format('d/m/Y')); ?></div>
                                    </td>
                                    <td>
                                        <?php switch($adj->type):
                                            case ('dispose'): ?>
                                                <span class="badge badge-danger"><?php echo e($adj->type_label); ?></span>
                                                <?php break; ?>
                                            <?php case ('correction'): ?>
                                                <span class="badge badge-info"><?php echo e($adj->type_label); ?></span>
                                                <?php break; ?>
                                            <?php case ('return'): ?>
                                                <span class="badge badge-warning"><?php echo e($adj->type_label); ?></span>
                                                <?php break; ?>
                                            <?php default: ?>
                                                <span class="badge"><?php echo e($adj->type_label); ?></span>
                                        <?php endswitch; ?>
                                    </td>
                                    <td class="text-center font-medium"><?php echo e($adj->quantity_before); ?></td>
                                    <td class="text-center text-red-600 font-bold">-<?php echo e($adj->quantity_adjusted); ?></td>
                                    <td class="text-center font-medium"><?php echo e($adj->quantity_after); ?></td>
                                    <td class="max-w-xs truncate text-sm"><?php echo e($adj->reason); ?></td>
                                    <td class="text-sm"><?php echo e($adj->user->name); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="py-12 text-center">
                                        <svg class="w-16 h-16 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        <p class="text-slate-400">Belum ada riwayat penyesuaian stok.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if($adjustments->hasPages()): ?>
                    <div class="p-4 border-t border-slate-100">
                        <?php echo e($adjustments->links()); ?>

                    </div>
                <?php endif; ?>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/stock-adjustments/index.blade.php ENDPATH**/ ?>