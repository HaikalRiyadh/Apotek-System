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
        <h2 class="text-xl font-bold text-slate-800">Supplier</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Kelola data supplier obat</p>
            <a href="<?php echo e(route('suppliers.create')); ?>" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Supplier
            </a>
        </div>
        <!-- Search -->
        <div class="card">
            <div class="card-body !py-3">
                <form method="GET" action="<?php echo e(route('suppliers.index')); ?>" class="flex gap-3 items-center">
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                               placeholder="Cari nama, email, telepon, atau kontak..."
                               class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                    </div>
                    <button type="submit" class="btn-primary !py-2">Cari</button>
                    <?php if(request('search')): ?>
                        <a href="<?php echo e(route('suppliers.index')); ?>" class="btn-secondary !py-2">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="overflow-x-auto">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Kontak</th>
                            <th class="text-center">Pembelian</th>
                            <th class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="font-semibold text-slate-700"><?php echo e($supplier->name); ?></td>
                                <td class="text-slate-500"><?php echo e($supplier->phone ?? '-'); ?></td>
                                <td class="text-slate-500"><?php echo e($supplier->email ?? '-'); ?></td>
                                <td class="text-slate-500"><?php echo e($supplier->contact_person ?? '-'); ?></td>
                                <td class="text-center"><span class="badge badge-info"><?php echo e($supplier->purchases_count); ?></span></td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="<?php echo e(route('suppliers.edit', $supplier)); ?>"
                                           class="btn-icon-sm bg-amber-50 text-amber-600 hover:bg-amber-100" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="<?php echo e(route('suppliers.destroy', $supplier)); ?>" method="POST" class="delete-form">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn-icon-sm bg-red-50 text-red-600 hover:bg-red-100" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="text-center py-12"><svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg><p class="text-sm text-slate-400">Belum ada data supplier</p></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($suppliers->hasPages()): ?>
            <div class="px-6 py-4 border-t border-slate-100"><?php echo e($suppliers->withQueryString()->links()); ?></div>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/suppliers/index.blade.php ENDPATH**/ ?>