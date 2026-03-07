<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Pembelian</h2>
            <a href="{{ route('purchases.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('purchases.store') }}"
                  x-data="{
                      items: {{ json_encode(old('items', [['medicine_id' => '', 'quantity' => 1, 'purchase_price' => 0, 'batch_number' => '', 'expired_date' => '']])) }},
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
                @csrf

                <!-- Info Pembelian -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pembelian</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Supplier -->
                        <div>
                            <x-input-label for="supplier_id" value="Supplier" />
                            <select id="supplier_id" name="supplier_id" required
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                        </div>

                        <!-- Tanggal Pembelian -->
                        <div>
                            <x-input-label for="purchase_date" value="Tanggal Pembelian" />
                            <x-text-input id="purchase_date" name="purchase_date" type="date"
                                           class="mt-1 block w-full"
                                           value="{{ old('purchase_date', date('Y-m-d')) }}" required />
                            <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="md:col-span-2">
                            <x-input-label for="notes" value="Catatan" />
                            <textarea id="notes" name="notes" rows="3"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Daftar Item -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Item Pembelian</h3>
                        <button type="button" @click="addItem()"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Tambah Item
                        </button>
                    </div>

                    @if($errors->has('items'))
                        <div class="mb-4 text-sm text-red-600">{{ $errors->first('items') }}</div>
                    @endif

                    {{-- Show all item-level validation errors --}}
                    @if($errors->any())
                        @php
                            $itemErrors = collect($errors->keys())->filter(fn($k) => str_starts_with($k, 'items.'))->map(fn($k) => $errors->first($k))->unique();
                        @endphp
                        @if($itemErrors->isNotEmpty())
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
                                <p class="text-sm font-semibold text-red-700 mb-2">Terdapat kesalahan pada item pembelian:</p>
                                <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                    @foreach($itemErrors as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obat</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-36">Harga Beli</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">No Batch</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Expired</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-36">Subtotal</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr>
                                        <!-- Obat -->
                                        <td class="px-4 py-2">
                                            <select :name="'items[' + index + '][medicine_id]'" x-model="item.medicine_id" required
                                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                <option value="">-- Pilih Obat --</option>
                                                @foreach($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}">
                                                        {{ $medicine->code }} - {{ $medicine->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <!-- Qty -->
                                        <td class="px-4 py-2">
                                            <input type="number" :name="'items[' + index + '][quantity]'" x-model.number="item.quantity"
                                                   min="1" required
                                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm text-center" />
                                        </td>
                                        <!-- Harga Beli -->
                                        <td class="px-4 py-2">
                                            <input type="number" :name="'items[' + index + '][purchase_price]'" x-model.number="item.purchase_price"
                                                   min="0" required
                                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm text-right" />
                                        </td>
                                        <!-- No Batch -->
                                        <td class="px-4 py-2">
                                            <input type="text" :name="'items[' + index + '][batch_number]'" x-model="item.batch_number"
                                                   required
                                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" />
                                        </td>
                                        <!-- Expired -->
                                        <td class="px-4 py-2">
                                            <input type="date" :name="'items[' + index + '][expired_date]'" x-model="item.expired_date"
                                                   required
                                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" />
                                        </td>
                                        <!-- Subtotal -->
                                        <td class="px-4 py-2 text-right text-sm font-medium text-gray-900" x-text="formatRupiah((item.quantity || 0) * (item.purchase_price || 0))">
                                        </td>
                                        <!-- Hapus -->
                                        <td class="px-4 py-2 text-center">
                                            <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                                    class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                &times;
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Grand Total -->
                    <div class="mt-4 flex justify-end">
                        <div class="bg-gray-50 rounded-lg px-6 py-4 text-right">
                            <span class="text-sm text-gray-500 uppercase tracking-wider">Grand Total</span>
                            <p class="text-2xl font-bold text-gray-900" x-text="formatRupiah(grandTotal)"></p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end">
                    <x-primary-button class="px-6 py-3">
                        Simpan Pembelian
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
