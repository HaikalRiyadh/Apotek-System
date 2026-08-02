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
            <a href="<?php echo e(route('sales.index')); ?>" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Detail Penjualan</h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-5 animate-fade-in">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Info Transaksi -->
            <div class="card">
                <div class="card-header"><h3 class="font-semibold text-slate-700">Informasi Transaksi</h3></div>
                <div class="card-body">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">No Invoice</dt>
                            <dd class="text-sm font-semibold text-emerald-600"><?php echo e($sale->invoice_number); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Tanggal</dt>
                            <dd class="text-sm text-slate-700"><?php echo e($sale->created_at->format('d/m/Y H:i:s')); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Kasir</dt>
                            <dd class="text-sm text-slate-700"><?php echo e($sale->user->name ?? '-'); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Pembayaran</dt>
                            <dd>
                                <span class="badge <?php echo e($sale->payment_method === 'cash' ? 'badge-success' : ($sale->payment_method === 'debit' ? 'badge-info' : 'badge-warning')); ?>">
                                    <?php echo e(ucfirst($sale->payment_method)); ?>

                                </span>
                            </dd>
                        </div>
                        <?php if($sale->notes): ?>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Catatan</dt>
                            <dd class="text-sm text-slate-700"><?php echo e($sale->notes); ?></dd>
                        </div>
                        <?php endif; ?>
                    </dl>
                </div>
            </div>

            <!-- Ringkasan Keuangan -->
            <div class="card">
                <div class="card-header"><h3 class="font-semibold text-slate-700">Ringkasan Keuangan</h3></div>
                <div class="card-body">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Subtotal</dt>
                            <dd class="text-sm text-slate-700">Rp <?php echo e(number_format($sale->subtotal, 0, ',', '.')); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Diskon</dt>
                            <dd class="text-sm text-red-500">- Rp <?php echo e(number_format($sale->discount, 0, ',', '.')); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Pajak</dt>
                            <dd class="text-sm text-slate-700">+ Rp <?php echo e(number_format($sale->tax, 0, ',', '.')); ?></dd>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-slate-100">
                            <dt class="text-base font-bold text-slate-800">Grand Total</dt>
                            <dd class="text-base font-bold text-emerald-600">Rp <?php echo e(number_format($sale->grand_total, 0, ',', '.')); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Dibayar</dt>
                            <dd class="text-sm font-medium text-slate-700">Rp <?php echo e(number_format($sale->amount_paid, 0, ',', '.')); ?></dd>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-slate-100">
                            <dt class="text-sm font-semibold text-slate-600">Kembalian</dt>
                            <dd class="text-sm font-semibold text-emerald-600">Rp <?php echo e(number_format($sale->change, 0, ',', '.')); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Detail Items -->
        <div class="card">
            <div class="card-header"><h3 class="font-semibold text-slate-700">Detail Barang</h3></div>
            <div class="overflow-x-auto">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th class="w-12">#</th>
                            <th>Obat</th>
                            <th class="text-right">Harga Jual</th>
                            <th class="text-right">Harga Beli (Avg)</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Subtotal</th>
                            <th class="text-right">Laba</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalProfit = 0; ?>
                        <?php $__currentLoopData = $sale->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $subtotalItem = $detail->selling_price * $detail->quantity;
                                $costItem = ($detail->purchase_price ?? 0) * $detail->quantity;
                                $profit = $subtotalItem - $costItem;
                                $totalProfit += $profit;
                            ?>
                            <tr>
                                <td class="text-slate-400"><?php echo e($index + 1); ?></td>
                                <td>
                                    <div class="font-medium text-slate-700"><?php echo e($detail->medicine->name ?? '-'); ?></div>
                                    <div class="text-xs text-slate-400"><?php echo e($detail->medicine->code ?? ''); ?></div>
                                </td>
                                <td class="text-right text-slate-600">Rp <?php echo e(number_format($detail->selling_price, 0, ',', '.')); ?></td>
                                <td class="text-right text-slate-500">Rp <?php echo e(number_format($detail->purchase_price ?? 0, 0, ',', '.')); ?></td>
                                <td class="text-center"><?php echo e($detail->quantity); ?></td>
                                <td class="text-right font-semibold text-slate-700">Rp <?php echo e(number_format($subtotalItem, 0, ',', '.')); ?></td>
                                <td class="text-right font-semibold <?php echo e($profit >= 0 ? 'text-emerald-600' : 'text-red-500'); ?>">Rp <?php echo e(number_format($profit, 0, ',', '.')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50">
                            <td colspan="6" class="text-right font-bold text-slate-600 text-xs uppercase tracking-wider">Total Laba Kotor</td>
                            <td class="text-right text-base font-bold <?php echo e($totalProfit >= 0 ? 'text-emerald-600' : 'text-red-500'); ?>">Rp <?php echo e(number_format($totalProfit, 0, ',', '.')); ?></td>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/sales/show.blade.php ENDPATH**/ ?>