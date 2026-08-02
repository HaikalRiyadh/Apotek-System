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
        <h2 class="text-xl font-bold text-slate-800">Kasir - Point of Sale</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-full mx-auto space-y-6 animate-fade-in" x-data="posData()" x-init="searchMedicine()" @keydown.escape="searchResults = []; searchQuery = ''">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT: Search & Cart -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Search -->
                <div class="card relative z-10">
                    <div class="card-body">
                        <label for="medicine-select" class="block text-sm font-medium text-slate-600 mb-2">Cari Obat</label>
                        <div class="relative">
                            <select id="medicine-select"
                                    x-model="selectedMedicineId"
                                    @change="selectMedicineFromSelect()"
                                    class="tom-select block w-full pl-4 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-emerald-500/20 focus:border-emerald-500 text-sm">
                                <option value="">-- Pilih Obat --</option>
                                <template x-for="medicine in searchResults" :key="medicine.id">
                                    <option :value="medicine.id" x-text="`${medicine.code} - ${medicine.name}`"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-slate-800">
                            <svg class="inline w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Keranjang
                        </h3>
                    </div>
                    <div class="card-body">
                        <div x-show="cart.length === 0" class="text-center py-8 text-slate-500">
                            <p>Keranjang masih kosong</p>
                        </div>
                        <div x-show="cart.length > 0" class="space-y-3">
                            <template x-for="(item, index) in cart" :key="index">
                                <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-lg border border-slate-200">
                                    <div class="flex-1">
                                        <p class="font-semibold text-slate-800" x-text="item.name"></p>
                                        <p class="text-xs text-slate-500" x-text="`${item.code} • ${item.unit}`"></p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="number" x-model.number="item.quantity" min="1" :max="item.stock"
                                               class="w-16 px-2 py-1 text-sm border border-slate-200 rounded-lg">
                                    </div>
                                    <div class="text-right min-w-24">
                                        <p class="font-semibold text-slate-800" x-text="formatPrice(item.selling_price * item.quantity)"></p>
                                        <p class="text-xs text-slate-500">@ <span x-text="formatPrice(item.selling_price)"></span></p>
                                    </div>
                                    <button type="button" @click="removeFromCart(index)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Payment Summary -->
            <div class="space-y-6">
                <!-- Summary Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-slate-800">Ringkasan Pembayaran</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <!-- Subtotal -->
                        <div class="flex justify-between items-center pb-4 border-b border-slate-200">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="font-semibold text-slate-800" x-text="formatPrice(subtotal)"></span>
                        </div>

                        <!-- Discount -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-600">Diskon (Rp)</label>
                            <input type="number" x-model.number="discount" min="0" 
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-emerald-500/20 focus:border-emerald-500">
                        </div>

                        <!-- Tax -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-600">Pajak (Rp)</label>
                            <input type="number" x-model.number="tax" min="0"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-emerald-500/20 focus:border-emerald-500">
                        </div>

                        <!-- Grand Total -->
                        <div class="flex justify-between items-center pt-4 border-t-2 border-slate-300 font-bold">
                            <span class="text-slate-800">Total Belanja</span>
                            <span class="text-xl text-emerald-600" x-text="formatPrice(grandTotal)"></span>
                        </div>
                    </div>
                </div>

                <!-- Payment Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-slate-800">Pembayaran</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <!-- Payment Method -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-600">Metode Pembayaran</label>
                            <select x-model="paymentMethod" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-emerald-500/20 focus:border-emerald-500">
                                <option value="cash">Tunai</option>
                                <option value="card">Kartu Kredit</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>

                        <!-- Amount Paid -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-600">Jumlah Pembayaran (Rp)</label>
                            <input type="number" x-model.number="amountPaid" min="0"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-emerald-500/20 focus:border-emerald-500 text-lg font-semibold">
                        </div>

                        <!-- Change -->
                        <div class="flex justify-between items-center pt-4 border-t border-slate-200 bg-slate-50 -mx-4 -mb-4 px-4 py-4 rounded-b-lg">
                            <span class="text-slate-600 font-medium">Kembalian</span>
                            <span class="text-xl font-bold text-emerald-600" x-text="formatPrice(change)"></span>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="card">
                    <div class="card-body">
                        <label class="text-sm font-medium text-slate-600 block mb-2">Catatan</label>
                        <textarea x-model="notes" rows="3" placeholder="Catatan tambahan (opsional)"
                                  class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-emerald-500/20 focus:border-emerald-500 text-sm"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <button @click="submitSale()" :disabled="loading" 
                        class="w-full btn-primary py-4 font-bold text-lg rounded-xl transition disabled:opacity-50 disabled:cursor-not-allowed"
                        :class="{ 'opacity-75': loading }">
                    <span x-show="!loading">💳 Proses Pembayaran</span>
                    <span x-show="loading">⏳ Memproses...</span>
                </button>
            </div>
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.css">
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        function posData() {
            return {
                searchQuery: '',
                searchResults: [],
                selectedMedicineId: '',
                tomSelect: null,
                cart: [],
                discount: 0,
                tax: 0,
                amountPaid: 0,
                paymentMethod: 'cash',
                notes: '',
                loading: false,

                async searchMedicine() {
                    try {
                        const res = await fetch('/api/medicines/search?q=' + encodeURIComponent(this.searchQuery));
                        this.searchResults = await res.json();
                        this.$nextTick(() => {
                            if (!this.tomSelect) {
                                this.tomSelect = new TomSelect('#medicine-select', {
                                    create: false,
                                    allowEmptyOption: true,
                                    placeholder: 'Pilih Obat',
                                    maxItems: 1,
                                    render: {
                                        option: (data, escape) => {
                                            const label = escape(data.text);
                                            return `<div class="py-1">${label}</div>`;
                                        }
                                    }
                                });
                            }
                        });
                    } catch (e) {
                        this.searchResults = [];
                    }
                },

                selectMedicineFromSelect() {
                    if (!this.selectedMedicineId) {
                        return;
                    }
                    const medicine = this.searchResults.find(item => item.id === Number(this.selectedMedicineId));
                    if (medicine) {
                        this.addToCart(medicine);
                    }
                    this.selectedMedicineId = '';
                    if (this.tomSelect) {
                        this.tomSelect.clear(true);
                    }
                },

                addToCart(medicine) {
                    const existing = this.cart.find(item => item.medicine_id === medicine.id);
                    if (existing) {
                        if (existing.quantity < medicine.stock_total) existing.quantity++;
                        return;
                    }
                    this.cart.push({
                        medicine_id: medicine.id,
                        name: medicine.name,
                        code: medicine.code,
                        selling_price: parseFloat(medicine.selling_price),
                        quantity: 1,
                        stock: medicine.stock_total,
                        unit: medicine.unit
                    });
                    this.searchQuery = '';
                    this.searchResults = [];
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                formatPrice(value) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.selling_price * item.quantity), 0);
                },

                get grandTotal() {
                    return this.subtotal - this.discount + this.tax;
                },

                get change() {
                    return Math.max(0, this.amountPaid - this.grandTotal);
                },

                async submitSale() {
                    if (this.cart.length === 0) { 
                        Swal.fire({ 
                            icon: 'warning', 
                            title: 'Keranjang Kosong', 
                            text: 'Tambahkan obat ke keranjang terlebih dahulu!', 
                            confirmButtonColor: '#10b981' 
                        }); 
                        return; 
                    }
                    if (this.amountPaid < this.grandTotal) { 
                        Swal.fire({ 
                            icon: 'warning', 
                            title: 'Pembayaran Kurang', 
                            text: 'Jumlah pembayaran kurang dari total belanja!', 
                            confirmButtonColor: '#10b981' 
                        }); 
                        return; 
                    }
                    this.loading = true;
                    try {
                        const res = await fetch('/sales', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                items: this.cart.map(item => ({
                                    medicine_id: item.medicine_id,
                                    quantity: item.quantity,
                                    selling_price: item.selling_price
                                })),
                                discount: this.discount,
                                tax: this.tax,
                                amount_paid: this.amountPaid,
                                payment_method: this.paymentMethod,
                                notes: this.notes
                            })
                        });
                        const data = await res.json();
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaksi Berhasil!',
                                text: 'Data penjualan telah disimpan.',
                                confirmButtonColor: '#10b981'
                            }).then(() => {
                                window.location.href = data.redirect;
                            });
                        } else {
                            Swal.fire({ 
                                icon: 'error', 
                                title: 'Gagal', 
                                text: data.message || 'Terjadi kesalahan', 
                                confirmButtonColor: '#dc2626' 
                            });
                        }
                    } catch (e) {
                        Swal.fire({ 
                            icon: 'error', 
                            title: 'Error', 
                            text: e.message, 
                            confirmButtonColor: '#dc2626' 
                        });
                    } finally {
                        this.loading = false;
                    }
                }
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
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/sales/create.blade.php ENDPATH**/ ?>