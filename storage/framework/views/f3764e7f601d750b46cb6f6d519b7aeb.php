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
            <a href="<?php echo e(route('stock-adjustments.index')); ?>" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Penyesuaian Stok</h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
            <div class="card" x-data="stockAdjustment()">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800">Form Penyesuaian</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('stock-adjustments.store')); ?>" class="space-y-5">
                        <?php echo csrf_field(); ?>

                        <!-- Medicine -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Obat <span class="text-red-500">*</span></label>
                            <select x-model="medicineId" @change="fetchBatches()"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">-- Pilih Obat --</option>
                                <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($medicine->id); ?>" <?php echo e($selectedBatch && $selectedBatch->medicine_id == $medicine->id ? 'selected' : ''); ?>>
                                        <?php echo e($medicine->name); ?> (Stok: <?php echo e($medicine->stock_total); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Batch -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Batch <span class="text-red-500">*</span></label>
                            <template x-if="loading">
                                <div class="flex items-center gap-2 text-sm text-slate-400 py-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    Memuat batch...
                                </div>
                            </template>
                            <select x-show="!loading" name="medicine_batch_id" x-model="batchId" @change="selectBatch()"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20"
                                    :required="true">
                                <option value="">-- Pilih Batch --</option>
                                <template x-for="batch in batches" :key="batch.id">
                                    <option :value="batch.id"
                                            :class="batch.is_expired ? 'text-red-600' : ''"
                                            x-text="batch.batch_number + ' | Exp: ' + batch.expired_date_formatted + ' | Sisa: ' + batch.remaining_quantity + (batch.is_expired ? ' ⚠️ EXPIRED' : '')">
                                    </option>
                                </template>
                            </select>
                            <?php $__errorArgs = ['medicine_batch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Batch Info -->
                        <div x-show="selectedBatch" x-transition
                             class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-slate-400">Batch No.</span>
                                    <p class="font-bold text-slate-700" x-text="selectedBatch?.batch_number"></p>
                                </div>
                                <div>
                                    <span class="text-slate-400">Tanggal Expired</span>
                                    <p class="font-bold" :class="selectedBatch?.is_expired ? 'text-red-600' : 'text-slate-700'" x-text="selectedBatch?.expired_date_formatted"></p>
                                </div>
                                <div>
                                    <span class="text-slate-400">Sisa Stok</span>
                                    <p class="font-bold text-slate-700" x-text="selectedBatch?.remaining_quantity"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Tipe Penyesuaian <span class="text-red-500">*</span></label>
                            <select name="type" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="dispose" <?php echo e(old('type') == 'dispose' ? 'selected' : ''); ?>>🗑️ Buang / Expired</option>
                                <option value="correction" <?php echo e(old('type') == 'correction' ? 'selected' : ''); ?>>📝 Koreksi Stok</option>
                                <option value="return" <?php echo e(old('type') == 'return' ? 'selected' : ''); ?>>↩️ Retur ke Supplier</option>
                                <option value="other" <?php echo e(old('type') == 'other' ? 'selected' : ''); ?>>📦 Lainnya</option>
                            </select>
                            <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Jumlah Dikurangi <span class="text-red-500">*</span></label>
                            <input type="number" name="quantity_adjusted" value="<?php echo e(old('quantity_adjusted')); ?>"
                                   min="1" :max="selectedBatch?.remaining_quantity || 99999" required
                                   placeholder="Masukkan jumlah yang akan dikurangi"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            <?php $__errorArgs = ['quantity_adjusted'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Reason -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Alasan <span class="text-red-500">*</span></label>
                            <textarea name="reason" rows="3" required
                                      placeholder="Contoh: Obat sudah melewati tanggal kadaluarsa"
                                      class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20"><?php echo e(old('reason')); ?></textarea>
                            <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end gap-3 pt-2">
                            <a href="<?php echo e(route('stock-adjustments.index')); ?>" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Simpan Penyesuaian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function stockAdjustment() {
            return {
                medicineId: '<?php echo e($selectedBatch ? $selectedBatch->medicine_id : ''); ?>',
                batchId: '<?php echo e($selectedBatch ? $selectedBatch->id : ''); ?>',
                batches: [],
                selectedBatch: null,
                loading: false,

                init() {
                    if (this.medicineId) {
                        this.fetchBatches();
                    }
                },

                async fetchBatches() {
                    if (!this.medicineId) {
                        this.batches = [];
                        this.selectedBatch = null;
                        return;
                    }
                    this.loading = true;
                    try {
                        const res = await fetch(`/stock-adjustments/batches/${this.medicineId}`);
                        const data = await res.json();
                        const today = new Date().toISOString().split('T')[0];
                        this.batches = data.map(b => ({
                            ...b,
                            expired_date_formatted: new Date(b.expired_date).toLocaleDateString('id-ID'),
                            is_expired: b.expired_date <= today,
                        }));
                        if (this.batchId) {
                            this.selectBatch();
                        }
                    } catch (e) {
                        console.error(e);
                    } finally {
                        this.loading = false;
                    }
                },

                selectBatch() {
                    this.selectedBatch = this.batches.find(b => b.id == this.batchId) || null;
                },
            };
        }
    </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/stock-adjustments/create.blade.php ENDPATH**/ ?>