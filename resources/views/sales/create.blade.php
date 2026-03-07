<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Kasir - Point of Sale</h2>
    </x-slot>

    <div class="max-w-full mx-auto space-y-6 animate-fade-in">
             x-data="{
                searchQuery: '',
                searchResults: [],
                cart: [],
                discount: 0,
                tax: 0,
                amountPaid: 0,
                paymentMethod: 'cash',
                notes: '',
                loading: false,

                async searchMedicine() {
                    if (this.searchQuery.length < 2) { this.searchResults = []; return; }
                    try {
                        const res = await fetch('/api/medicines/search?q=' + encodeURIComponent(this.searchQuery));
                        this.searchResults = await res.json();
                    } catch (e) {
                        this.searchResults = [];
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
                    return new Intl.NumberFormat('id-ID').format(value);
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
                    if (this.cart.length === 0) { Swal.fire({ icon: 'warning', title: 'Keranjang Kosong', text: 'Tambahkan obat ke keranjang terlebih dahulu!', confirmButtonColor: '#10b981' }); return; }
                    if (this.amountPaid < this.grandTotal) { Swal.fire({ icon: 'warning', title: 'Pembayaran Kurang', text: 'Jumlah pembayaran kurang dari total belanja!', confirmButtonColor: '#10b981' }); return; }
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
                            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan', confirmButtonColor: '#dc2626' });
                        }
                    } catch (e) {
                        Swal.fire({ icon: 'error', title: 'Error', text: e.message, confirmButtonColor: '#dc2626' });
                    } finally {
                        this.loading = false;
                    }
                }
             }">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LEFT: Search & Cart --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Search --}}
                    <div class="card relative z-10">
                        <div class="card-body">
                            <label for="search" class="block text-sm font-medium text-slate-600 mb-2">Cari Obat</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" id="search"
                                       x-model="searchQuery"
                                       x-on:input.debounce.300ms="searchMedicine()"
                                       x-on:keydown.escape="searchResults = []; searchQuery = ''"
                                       placeholder="Ketik nama atau kode obat..."
                                       autocomplete="off"
                                       class="block w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-emerald-500/20 focus:border-emerald-500 text-sm">

                                {{-- Search Results Dropdown --}}
                                <div x-show="searchResults.length > 0"
                                     x-on:click.outside="searchResults = []"
                                     x-transition
                                     style="z-index: 9999;"
                                     class="absolute w-full mt-2 bg-white border border-slate-200 rounded-2xl shadow-2xl max-h-72 overflow-y-auto">
                                    <template x-for="(medicine, index) in searchResults" :key="medicine.id">
                                        <button type="button"
                                                x-on:click="addToCart(medicine)"
                                                class="w-full text-left px-5 py-3.5 hover:bg-emerald-50 transition border-b border-slate-100 last:border-b-0 flex justify-between items-center">
                                            <div>
                                                <div class="font-semibold text-slate-800" x-text="medicine.name"></div>
                                                <div class="text-xs text-slate-400 mt-0.5">
                                                    <span x-text="medicine.code"></span> &middot;
                                                    Stok: <span x-text="medicine.stock_total"></span>
                                                    <span x-text="medicine.unit"></span>
                                                </div>
                                            </div>
                                            <div class="text-sm font-bold text-emerald-600">
                                                Rp <span x-text="formatPrice(medicine.selling_price)"></span>
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Cart --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                Keranjang
                                <span class="text-sm font-normal text-slate-400" x-text="'(' + cart.length + ' item)'"></span>
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="pro-table">
                                <thead>
                                    <tr>
                                        <th>Obat</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-center w-36">Qty</th>
                                        <th class="text-right">Subtotal</th>
                                        <th class="w-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in cart" :key="item.medicine_id">
                                        <tr>
                                            <td>
                                                <div class="font-semibold text-slate-800" x-text="item.name"></div>
                                                <div class="text-xs text-slate-400 mt-0.5">
                                                    <span x-text="item.code"></span> &middot;
                                                    Stok: <span x-text="item.stock"></span> <span x-text="item.unit"></span>
                                                </div>
                                            </td>
                                            <td class="text-right whitespace-nowrap">
                                                Rp <span x-text="formatPrice(item.selling_price)"></span>
                                            </td>
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    <button type="button"
                                                            x-on:click="item.quantity > 1 ? item.quantity-- : null"
                                                            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-emerald-100 text-slate-600 hover:text-emerald-600 flex items-center justify-center transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                                    </button>
                                                    <input type="number"
                                                           x-model.number="item.quantity"
                                                           min="1"
                                                           :max="item.stock"
                                                           class="w-16 text-center bg-slate-50 border border-slate-200 rounded-xl text-sm py-1.5 focus:ring-emerald-500/20 focus:border-emerald-500">
                                                    <button type="button"
                                                            x-on:click="item.quantity < item.stock ? item.quantity++ : null"
                                                            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-emerald-100 text-slate-600 hover:text-emerald-600 flex items-center justify-center transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-right font-bold text-emerald-600 whitespace-nowrap">
                                                Rp <span x-text="formatPrice(item.selling_price * item.quantity)"></span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                        x-on:click="removeFromCart(index)"
                                                        class="btn-icon-sm bg-red-50 text-red-500 hover:bg-red-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>

                            {{-- Empty Cart --}}
                            <div x-show="cart.length === 0" class="py-16 text-center">
                                <svg class="w-20 h-20 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                <p class="text-sm text-slate-400">Keranjang masih kosong. Cari dan tambahkan obat di atas.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Summary --}}
                <div class="lg:col-span-1">
                    <div class="card sticky top-6">
                        <div class="p-6 space-y-5">
                            <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Ringkasan Pembayaran
                            </h3>

                            {{-- Subtotal --}}
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500">Subtotal</span>
                                <span class="font-semibold text-slate-700">Rp <span x-text="formatPrice(subtotal)"></span></span>
                            </div>

                            {{-- Diskon --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Diskon (Rp)</label>
                                <input type="number" x-model.number="discount" min="0"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm py-2.5 px-4 focus:ring-emerald-500/20 focus:border-emerald-500"
                                       placeholder="0">
                            </div>

                            {{-- Pajak --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Pajak (Rp)</label>
                                <input type="number" x-model.number="tax" min="0"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm py-2.5 px-4 focus:ring-emerald-500/20 focus:border-emerald-500"
                                       placeholder="0">
                            </div>

                            {{-- Grand Total --}}
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-4 text-white">
                                <div class="flex justify-between items-center">
                                    <span class="text-emerald-100 text-sm font-medium">Grand Total</span>
                                    <span class="text-2xl font-bold">Rp <span x-text="formatPrice(grandTotal)"></span></span>
                                </div>
                            </div>

                            {{-- Bayar --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Bayar (Rp)</label>
                                <input type="number" x-model.number="amountPaid" min="0"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm py-2.5 px-4 focus:ring-emerald-500/20 focus:border-emerald-500"
                                       placeholder="0">
                            </div>

                            {{-- Kembalian --}}
                            <div class="flex justify-between items-center text-sm bg-emerald-50 rounded-xl px-4 py-3">
                                <span class="text-emerald-700 font-medium">Kembalian</span>
                                <span class="font-bold text-emerald-600 text-lg">Rp <span x-text="formatPrice(change)"></span></span>
                            </div>

                            {{-- Metode Pembayaran --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Metode Pembayaran</label>
                                <select x-model="paymentMethod"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm py-2.5 px-4 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    <option value="cash">Cash</option>
                                    <option value="debit">Debit</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>

                            {{-- Catatan --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Catatan</label>
                                <textarea x-model="notes" rows="2"
                                          class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm py-2.5 px-4 focus:ring-emerald-500/20 focus:border-emerald-500"
                                          placeholder="Catatan tambahan (opsional)"></textarea>
                            </div>

                            {{-- Submit --}}
                            <button type="button"
                                    x-on:click="submitSale()"
                                    :disabled="loading || cart.length === 0"
                                    :class="{'opacity-50 cursor-not-allowed': loading || cart.length === 0}"
                                    class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 border border-transparent rounded-2xl font-semibold text-sm text-white uppercase tracking-widest hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/30 transition">
                                <template x-if="loading">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </template>
                                <template x-if="!loading">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </template>
                                <span x-text="loading ? 'Memproses...' : 'Simpan Transaksi'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
