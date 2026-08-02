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
        <h2 class="text-xl font-bold text-slate-800">Penjualan</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Riwayat transaksi penjualan</p>
            <a href="<?php echo e(route('sales.create')); ?>" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Transaksi Baru
            </a>
        </div>
        <!-- Filter -->
        <div class="card">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('sales.index')); ?>" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Cari Invoice/Kasir</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="No. invoice atau kasir..."
                                   class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                    </div>
                    <div class="w-40">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>"
                               class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                    </div>
                    <div class="w-40">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>"
                               class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                    </div>
                    <div class="w-36">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Pembayaran</label>
                        <select name="payment_method" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            <option value="">Semua</option>
                            <option value="cash" <?php echo e(request('payment_method') == 'cash' ? 'selected' : ''); ?>>Cash</option>
                            <option value="transfer" <?php echo e(request('payment_method') == 'transfer' ? 'selected' : ''); ?>>Transfer</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary !py-2">Filter</button>
                        <a href="<?php echo e(route('sales.index')); ?>" class="btn-secondary !py-2">Reset</a>
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
                            <th>No Invoice</th>
                            <th>Tanggal</th>
                            <th class="text-right">Subtotal</th>
                            <th class="text-right">Diskon</th>
                            <th class="text-right">Pajak</th>
                            <th class="text-right">Grand Total</th>
                            <th>Kasir</th>
                            <th class="text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="font-semibold text-emerald-600"><?php echo e($sale->invoice_number); ?></td>
                                <td class="text-slate-500"><?php echo e($sale->created_at->format('d/m/Y H:i')); ?></td>
                                <td class="text-right text-slate-600">Rp <?php echo e(number_format($sale->subtotal, 0, ',', '.')); ?></td>
                                <td class="text-right text-slate-500">Rp <?php echo e(number_format($sale->discount, 0, ',', '.')); ?></td>
                                <td class="text-right text-slate-500">Rp <?php echo e(number_format($sale->tax, 0, ',', '.')); ?></td>
                                <td class="text-right font-bold text-slate-800">Rp <?php echo e(number_format($sale->grand_total, 0, ',', '.')); ?></td>
                                <td class="text-slate-500"><?php echo e($sale->user->name ?? '-'); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('sales.show', $sale)); ?>"
                                       class="btn-icon-sm bg-emerald-50 text-emerald-600 hover:bg-emerald-100" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="8" class="text-center py-12"><svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg><p class="text-sm text-slate-400">Belum ada data penjualan</p></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($sales->hasPages()): ?>
            <div class="px-6 py-4 border-t border-slate-100"><?php echo e($sales->withQueryString()->links()); ?></div>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/sales/index.blade.php ENDPATH**/ ?>