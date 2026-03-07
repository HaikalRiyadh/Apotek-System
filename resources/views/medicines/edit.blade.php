<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('medicines.index') }}" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Edit Obat</h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto animate-fade-in">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('medicines.update', $medicine) }}" class="space-y-5">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="code" class="block text-sm font-medium text-slate-600 mb-1">Kode Obat <span class="text-red-400">*</span></label>
                            <input type="text" id="code" name="code" value="{{ old('code', $medicine->code) }}" required
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            <x-input-error :messages="$errors->get('code')" class="mt-1" />
                        </div>
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-600 mb-1">Nama Obat <span class="text-red-400">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $medicine->name) }}" required
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-slate-600 mb-1">Kategori <span class="text-red-400">*</span></label>
                            <select id="category_id" name="category_id" required
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $medicine->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
                        </div>
                        <div>
                            <label for="unit_id" class="block text-sm font-medium text-slate-600 mb-1">Satuan <span class="text-red-400">*</span></label>
                            <select id="unit_id" name="unit_id" required
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id', $medicine->unit_id) == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('unit_id')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label for="default_purchase_price" class="block text-sm font-medium text-slate-600 mb-1">Harga Beli <span class="text-red-400">*</span></label>
                            <input type="number" id="default_purchase_price" name="default_purchase_price" min="0" value="{{ old('default_purchase_price', $medicine->default_purchase_price) }}" required
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            <x-input-error :messages="$errors->get('default_purchase_price')" class="mt-1" />
                        </div>
                        <div>
                            <label for="selling_price" class="block text-sm font-medium text-slate-600 mb-1">Harga Jual <span class="text-red-400">*</span></label>
                            <input type="number" id="selling_price" name="selling_price" min="0" value="{{ old('selling_price', $medicine->selling_price) }}" required
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            <x-input-error :messages="$errors->get('selling_price')" class="mt-1" />
                        </div>
                        <div>
                            <label for="minimum_stock" class="block text-sm font-medium text-slate-600 mb-1">Stok Minimum <span class="text-red-400">*</span></label>
                            <input type="number" id="minimum_stock" name="minimum_stock" min="0" value="{{ old('minimum_stock', $medicine->minimum_stock) }}" required
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            <x-input-error :messages="$errors->get('minimum_stock')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-600 mb-1">Deskripsi</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">{{ old('description', $medicine->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('medicines.index') }}" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
