<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('units.index') }}" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Edit Satuan</h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto animate-fade-in">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('units.update', $unit) }}" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-600 mb-1">Nama <span class="text-red-400">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $unit->name) }}" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        @error('name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="abbreviation" class="block text-sm font-medium text-slate-600 mb-1">Singkatan</label>
                        <input type="text" name="abbreviation" id="abbreviation" value="{{ old('abbreviation', $unit->abbreviation) }}"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        @error('abbreviation')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('units.index') }}" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
