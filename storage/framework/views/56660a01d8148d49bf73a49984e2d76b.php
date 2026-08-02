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
            <a href="<?php echo e(route('purchases.index')); ?>" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Detail Pembelian</h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-5 animate-fade-in">
        <div class="card">
            <div class="card-header"><h3 class="font-semibold text-slate-700">Informasi Pembelian</h3></div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">No Invoice</span>
                        <p class="mt-1 text-sm font-semibold text-emerald-600"><?php echo e($purchase->invoice_number); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Supplier</span>
                        <p class="mt-1 text-sm font-semibold text-slate-700"><?php echo e($purchase->supplier->name ?? '-'); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Tanggal</span>
                        <p class="mt-1 text-sm text-slate-600"><?php echo e($purchase->purchase_date->format('d/m/Y')); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total</span>
                        <p class="mt-1 text-lg font-bold text-slate-800">Rp <?php echo e(number_format($purchase->total_amount, 0, ',', '.')); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">User</span>
                        <p class="mt-1 text-sm text-slate-600"><?php echo e($purchase->user->name ?? '-'); ?></p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Catatan</span>
                        <p class="mt-1 text-sm text-slate-600"><?php echo e($purchase->notes ?? '-'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="font-semibold text-slate-700">Detail Item</h3></div>
            <div class="overflow-x-auto">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Harga Beli</th>
                            <th class="text-right">Subtotal</th>
                            <th>No Batch</th>
                            <th>Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $purchase->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="font-medium text-slate-700"><?php echo e($detail->medicine->name ?? '-'); ?></td>
                                <td class="text-center"><?php echo e($detail->quantity); ?></td>
                                <td class="text-right text-slate-600">Rp <?php echo e(number_format($detail->purchase_price, 0, ',', '.')); ?></td>
                                <td class="text-right font-semibold text-slate-700">Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></td>
                                <td class="text-slate-500"><?php echo e($detail->batch_number); ?></td>
                                <td>
                                    <?php if($detail->expired_date): ?>
                                        <span class="<?php echo e($detail->expired_date->isPast() ? 'text-red-500 font-semibold' : 'text-slate-500'); ?>"><?php echo e($detail->expired_date->format('d/m/Y')); ?></span>
                                    <?php else: ?> - <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="text-center py-8 text-sm text-slate-400">Tidak ada detail item</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50">
                            <td colspan="3" class="text-right font-bold text-slate-600 uppercase text-xs tracking-wider">Total</td>
                            <td class="text-right font-bold text-emerald-600">Rp <?php echo e(number_format($purchase->total_amount, 0, ',', '.')); ?></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/purchases/show.blade.php ENDPATH**/ ?>