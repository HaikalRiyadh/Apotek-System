<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kasir - Point of Sale
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8"
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
                    if (this.cart.length === 0) { Swal.fire({ icon: 'warning', title: 'Keranjang Kosong', text: 'Tambahkan obat ke keranjang terlebih dahulu!', confirmButtonColor: '#f59e0b' }); return; }
                    if (this.amountPaid < this.grandTotal) { Swal.fire({ icon: 'warning', title: 'Pembayaran Kurang', text: 'Jumlah pembayaran kurang dari total belanja!', confirmButtonColor: '#f59e0b' }); return; }
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
                                confirmButtonColor: '#4f46e5'
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
                    <div class="bg-white shadow-sm sm:rounded-lg relative z-10">
                        <div class="p-6">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Obat</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" id="search"
                                       x-model="searchQuery"
                                       x-on:input.debounce.300ms="searchMedicine()"
                                       x-on:keydown.escape="searchResults = []; searchQuery = ''"
                                       placeholder="Ketik nama atau kode obat..."
                                       autocomplete="off"
                                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">

                                {{-- Search Results Dropdown --}}
                                <div x-show="searchResults.length > 0"
                                     x-on:click.outside="searchResults = []"
                                     x-transition
                                     style="z-index: 9999;"
                                     class="absolute w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-72 overflow-y-auto">
                                    <template x-for="(medicine, index) in searchResults" :key="medicine.id">
                                        <button type="button"
                                                x-on:click="addToCart(medicine)"
                                                class="w-full text-left px-4 py-3 hover:bg-blue-50 transition border-b border-gray-100 last:border-b-0 flex justify-between items-center">
                                            <div>
                                                <div class="font-medium text-gray-900" x-text="medicine.name"></div>
                                                <div class="text-xs text-gray-500">
                                                    <span x-text="medicine.code"></span> &middot;
                                                    Stok: <span x-text="medicine.stock_total"></span>
                                                    <span x-text="medicine.unit"></span>
                                                </div>
                                            </div>
                                            <div class="text-sm font-semibold text-blue-600">
                                                Rp <span x-text="formatPrice(medicine.selling_price)"></span>
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Cart --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <svg class="w-5 h-5 inline mr-1 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                Keranjang
                                <span class="text-sm font-normal text-gray-500" x-text="'(' + cart.length + ' item)'"></span>
                            </h3>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obat</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Qty</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <template x-for="(item, index) in cart" :key="item.medicine_id">
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3">
                                                    <div class="text-sm font-medium text-gray-900" x-text="item.name"></div>
                                                    <div class="text-xs text-gray-500">
                                                        <span x-text="item.code"></span> &middot;
                                                        Stok: <span x-text="item.stock"></span> <span x-text="item.unit"></span>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-right text-sm text-gray-700 whitespace-nowrap">
                                                    Rp <span x-text="formatPrice(item.selling_price)"></span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <div class="flex items-center justify-center gap-1">
                                                        <button type="button"
                                                                x-on:click="item.quantity > 1 ? item.quantity-- : null"
                                                                class="w-8 h-8 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                                        </button>
                                                        <input type="number"
                                                               x-model.number="item.quantity"
                                                               min="1"
                                                               :max="item.stock"
                                                               class="w-16 text-center border border-gray-300 rounded-md text-sm py-1 focus:ring-blue-500 focus:border-blue-500">
                                                        <button type="button"
                                                                x-on:click="item.quantity < item.stock ? item.quantity++ : null"
                                                                class="w-8 h-8 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-right text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                    Rp <span x-text="formatPrice(item.selling_price * item.quantity)"></span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <button type="button"
                                                            x-on:click="removeFromCart(index)"
                                                            class="text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md p-1.5 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>

                                {{-- Empty Cart --}}
                                <div x-show="cart.length === 0" class="py-12 text-center text-gray-400">
                                    <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                    <p class="text-sm">Keranjang masih kosong. Cari dan tambahkan obat di atas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 space-y-5">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-3">Ringkasan Pembayaran</h3>

                            {{-- Subtotal --}}
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900">Rp <span x-text="formatPrice(subtotal)"></span></span>
                            </div>

                            {{-- Diskon --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Diskon (Rp)</label>
                                <input type="number" x-model.number="discount" min="0"
                                       class="block w-full border border-gray-300 rounded-md shadow-sm text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="0">
                            </div>

                            {{-- Pajak --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Pajak (Rp)</label>
                                <input type="number" x-model.number="tax" min="0"
                                       class="block w-full border border-gray-300 rounded-md shadow-sm text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="0">
                            </div>

                            {{-- Grand Total --}}
                            <div class="flex justify-between items-center text-base font-bold border-t border-b py-3">
                                <span class="text-gray-800">Grand Total</span>
                                <span class="text-blue-600">Rp <span x-text="formatPrice(grandTotal)"></span></span>
                            </div>

                            {{-- Bayar --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Bayar (Rp)</label>
                                <input type="number" x-model.number="amountPaid" min="0"
                                       class="block w-full border border-gray-300 rounded-md shadow-sm text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="0">
                            </div>

                            {{-- Kembalian --}}
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Kembalian</span>
                                <span class="font-semibold text-green-600 text-base">Rp <span x-text="formatPrice(change)"></span></span>
                            </div>

                            {{-- Metode Pembayaran --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Metode Pembayaran</label>
                                <select x-model="paymentMethod"
                                        class="block w-full border border-gray-300 rounded-md shadow-sm text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="cash">Cash</option>
                                    <option value="debit">Debit</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>

                            {{-- Catatan --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Catatan</label>
                                <textarea x-model="notes" rows="2"
                                          class="block w-full border border-gray-300 rounded-md shadow-sm text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Catatan tambahan (opsional)"></textarea>
                            </div>

                            {{-- Submit --}}
                            <button type="button"
                                    x-on:click="submitSale()"
                                    :disabled="loading || cart.length === 0"
                                    :class="{'opacity-50 cursor-not-allowed': loading || cart.length === 0}"
                                    class="w-full flex items-center justify-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 transition">
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
    </div>
</x-app-layout>
