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
        <h2 class="text-xl font-bold text-slate-800">Laporan Obat Hampir Expired</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Pantau obat yang mendekati atau sudah melewati masa kadaluarsa</p>
            <button type="button" onclick="window.print()" class="btn-secondary print:hidden">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </button>
        </div>

            
            <div class="card print:hidden">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('reports.expiring')); ?>" class="flex flex-wrap items-end gap-4">
                        <div>
                            <label for="days" class="block text-sm font-medium text-slate-600 mb-1">Periode (hari ke depan)</label>
                            <input type="number" name="days" id="days" min="1"
                                   value="<?php echo e($days); ?>"
                                   class="w-32 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div>
                            <button type="submit" class="btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="card overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-rose-600 border-b">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Obat Sudah Expired</h3>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Obat</th>
                                <th>Batch</th>
                                <th class="text-center">Sisa Qty</th>
                                <th>Expired Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $expired; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-slate-400"><?php echo e($index + 1); ?></td>
                                    <td class="font-medium"><?php echo e($batch->medicine->name ?? '-'); ?></td>
                                    <td><span class="badge badge-info"><?php echo e($batch->batch_number); ?></span></td>
                                    <td class="text-center font-semibold"><?php echo e($batch->remaining_quantity); ?></td>
                                    <td>
                                        <span class="font-semibold text-red-600"><?php echo e(\Carbon\Carbon::parse($batch->expiry_date)->format('d/m/Y')); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400">Tidak ada obat yang sudah expired.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="card overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-500 border-b">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Obat Mendekati Expired (<?php echo e($days); ?> hari)</h3>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Obat</th>
                                <th>Batch</th>
                                <th class="text-center">Sisa Qty</th>
                                <th>Expired Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $expiring; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-slate-400"><?php echo e($index + 1); ?></td>
                                    <td class="font-medium"><?php echo e($batch->medicine->name ?? '-'); ?></td>
                                    <td><span class="badge badge-info"><?php echo e($batch->batch_number); ?></span></td>
                                    <td class="text-center font-semibold"><?php echo e($batch->remaining_quantity); ?></td>
                                    <td>
                                        <span class="font-semibold text-amber-600"><?php echo e(\Carbon\Carbon::parse($batch->expiry_date)->format('d/m/Y')); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400">Tidak ada obat yang mendekati expired.</td>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/reports/expiring.blade.php ENDPATH**/ ?>