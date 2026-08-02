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
            <h2 class="text-xl font-bold text-slate-800">Tambah Pembelian</h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
            <form method="POST" action="<?php echo e(route('purchases.store')); ?>"
                  x-data="{
                      items: <?php echo e(json_encode(old('items', [['medicine_id' => '', 'quantity' => 1, 'purchase_price' => 0, 'batch_number' => '', 'expired_date' => '']]))); ?>,
                      addItem() {
                          this.items.push({ medicine_id: '', quantity: 1, purchase_price: 0, batch_number: '', expired_date: '' });
                      },
                      removeItem(index) {
                          this.items.splice(index, 1);
                      },
                      get grandTotal() {
                          return this.items.reduce((sum, item) => sum + (parseInt(item.quantity) || 0) * (parseFloat(item.purchase_price) || 0), 0);
                      },
                      formatRupiah(value) {
                          return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
                      }
                  }">
                <?php echo csrf_field(); ?>

                <!-- Info Pembelian -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-slate-800">Informasi Pembelian</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-slate-600 mb-1">Supplier <span class="text-red-400">*</span></label>
                                <select id="supplier_id" name="supplier_id" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                    <option value="">-- Pilih Supplier --</option>
                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($supplier->id); ?>" <?php echo e(old('supplier_id') == $supplier->id ? 'selected' : ''); ?>>
                                            <?php echo e($supplier->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('supplier_id'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('supplier_id')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>

                            <div>
                                <label for="purchase_date" class="block text-sm font-medium text-slate-600 mb-1">Tanggal Pembelian <span class="text-red-400">*</span></label>
                                <input id="purchase_date" name="purchase_date" type="date"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20"
                                       value="<?php echo e(old('purchase_date', date('Y-m-d'))); ?>" required />
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('purchase_date'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('purchase_date')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-slate-600 mb-1">Catatan</label>
                                <textarea id="notes" name="notes" rows="3"
                                          class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20"
                                          placeholder="Catatan tambahan (opsional)"><?php echo e(old('notes')); ?></textarea>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('notes'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('notes')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Item -->
                <div class="card">
                    <div class="card-header flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-800">Item Pembelian</h3>
                        <button type="button" @click="addItem()"
                                class="btn-primary !py-2 !px-4 !text-xs">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Item
                        </button>
                    </div>
                    <div class="card-body">
                        <?php if($errors->has('items')): ?>
                            <div class="mb-4 text-sm text-red-600"><?php echo e($errors->first('items')); ?></div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <?php
                                $itemErrors = collect($errors->keys())->filter(fn($k) => str_starts_with($k, 'items.'))->map(fn($k) => $errors->first($k))->unique();
                            ?>
                            <?php if($itemErrors->isNotEmpty()): ?>
                                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                                    <p class="text-sm font-semibold text-red-700 mb-2">Terdapat kesalahan pada item pembelian:</p>
                                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                        <?php $__currentLoopData = $itemErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($err); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="overflow-x-auto">
                            <table class="pro-table">
                                <thead>
                                    <tr>
                                        <th>Obat</th>
                                        <th class="text-center w-24">Qty</th>
                                        <th class="text-right w-36">Harga Beli</th>
                                        <th class="w-36">No Batch</th>
                                        <th class="w-40">Expired</th>
                                        <th class="text-right w-36">Subtotal</th>
                                        <th class="w-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr>
                                            <td>
                                                <select :name="'items[' + index + '][medicine_id]'" x-model="item.medicine_id" required
                                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                                    <option value="">-- Pilih Obat --</option>
                                                    <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($medicine->id); ?>">
                                                            <?php echo e($medicine->code); ?> - <?php echo e($medicine->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" :name="'items[' + index + '][quantity]'" x-model.number="item.quantity"
                                                       min="1" required
                                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm text-center focus:border-emerald-500 focus:ring-emerald-500/20" />
                                            </td>
                                            <td>
                                                <input type="number" :name="'items[' + index + '][purchase_price]'" x-model.number="item.purchase_price"
                                                       min="0" required
                                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm text-right focus:border-emerald-500 focus:ring-emerald-500/20" />
                                            </td>
                                            <td>
                                                <input type="text" :name="'items[' + index + '][batch_number]'" x-model="item.batch_number"
                                                       required
                                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20" />
                                            </td>
                                            <td>
                                                <input type="date" :name="'items[' + index + '][expired_date]'" x-model="item.expired_date"
                                                       required
                                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20" />
                                            </td>
                                            <td class="text-right font-semibold text-emerald-600" x-text="formatRupiah((item.quantity || 0) * (item.purchase_price || 0))">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                                        class="btn-icon-sm bg-red-50 text-red-500 hover:bg-red-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Grand Total -->
                        <div class="mt-6 flex justify-end">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl px-8 py-5 text-right text-white shadow-lg shadow-emerald-500/20">
                                <span class="text-emerald-100 text-xs uppercase tracking-wider font-medium">Grand Total</span>
                                <p class="text-3xl font-bold mt-1" x-text="formatRupiah(grandTotal)"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end gap-3">
                    <a href="<?php echo e(route('purchases.index')); ?>" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Pembelian
                    </button>
                </div>
            </form>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/purchases/create.blade.php ENDPATH**/ ?>