<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Obat: {{ $medicine->name }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('medicines.update', $medicine) }}">
                    @csrf
                    @method('PUT')

                    <!-- Kode -->
                    <div class="mb-4">
                        <x-input-label for="code" value="Kode Obat" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full"
                                       value="{{ old('code', $medicine->code) }}" required />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <!-- Nama -->
                    <div class="mb-4">
                        <x-input-label for="name" value="Nama Obat" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                       value="{{ old('name', $medicine->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <x-input-label for="category_id" value="Kategori" />
                        <select id="category_id" name="category_id" required
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $medicine->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Satuan -->
                    <div class="mb-4">
                        <x-input-label for="unit_id" value="Satuan" />
                        <select id="unit_id" name="unit_id" required
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Pilih Satuan --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id', $medicine->unit_id) == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('unit_id')" class="mt-2" />
                    </div>

                    <!-- Harga Beli -->
                    <div class="mb-4">
                        <x-input-label for="default_purchase_price" value="Harga Beli Default" />
                        <x-text-input id="default_purchase_price" name="default_purchase_price" type="number"
                                       class="mt-1 block w-full" min="0"
                                       value="{{ old('default_purchase_price', $medicine->default_purchase_price) }}" required />
                        <x-input-error :messages="$errors->get('default_purchase_price')" class="mt-2" />
                    </div>

                    <!-- Harga Jual -->
                    <div class="mb-4">
                        <x-input-label for="selling_price" value="Harga Jual" />
                        <x-text-input id="selling_price" name="selling_price" type="number"
                                       class="mt-1 block w-full" min="0"
                                       value="{{ old('selling_price', $medicine->selling_price) }}" required />
                        <x-input-error :messages="$errors->get('selling_price')" class="mt-2" />
                    </div>

                    <!-- Stok Minimum -->
                    <div class="mb-4">
                        <x-input-label for="minimum_stock" value="Stok Minimum" />
                        <x-text-input id="minimum_stock" name="minimum_stock" type="number"
                                       class="mt-1 block w-full" min="0"
                                       value="{{ old('minimum_stock', $medicine->minimum_stock) }}" required />
                        <x-input-error :messages="$errors->get('minimum_stock')" class="mt-2" />
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <x-input-label for="description" value="Deskripsi" />
                        <textarea id="description" name="description" rows="3"
                                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $medicine->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('medicines.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Batal
                        </a>
                        <x-primary-button>Perbarui</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
