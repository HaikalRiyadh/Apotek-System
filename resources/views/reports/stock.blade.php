<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Laporan Stok</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Daftar stok seluruh obat saat ini</p>
            <button onclick="window.print()" class="btn-secondary print:hidden">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </button>
        </div>

            <div class="card">
                <div class="overflow-x-auto">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Obat</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th class="text-right">Harga Beli</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Min Stok</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicines as $index => $medicine)
                                <tr>
                                    <td class="text-slate-400">{{ $index + 1 }}</td>
                                    <td class="font-semibold text-emerald-600">{{ $medicine->code }}</td>
                                    <td class="font-medium">{{ $medicine->name }}</td>
                                    <td>{{ $medicine->category->name ?? '-' }}</td>
                                    <td>{{ $medicine->unit->name ?? '-' }}</td>
                                    <td class="text-right">Rp {{ number_format($medicine->purchase_price, 0, ',', '.') }}</td>
                                    <td class="text-right">Rp {{ number_format($medicine->selling_price, 0, ',', '.') }}</td>
                                    <td class="text-center font-semibold">{{ $medicine->stock_total }}</td>
                                    <td class="text-center text-slate-400">{{ $medicine->minimum_stock }}</td>
                                    <td class="text-center">
                                        @if($medicine->stock_total <= $medicine->minimum_stock)
                                            <span class="badge badge-danger">Rendah</span>
                                        @else
                                            <span class="badge badge-success">Normal</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-8 text-slate-400">Tidak ada data obat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
</x-app-layout>
