<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Obat: {{ $medicine->name }}</h2>
            <a href="{{ route('medicines.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Medicine Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Informasi Obat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-500">Kode</span>
                        <p class="text-gray-900 font-medium">{{ $medicine->code }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Nama</span>
                        <p class="text-gray-900 font-medium">{{ $medicine->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Kategori</span>
                        <p class="text-gray-900 font-medium">{{ $medicine->category->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Satuan</span>
                        <p class="text-gray-900 font-medium">{{ $medicine->unit->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Harga Beli Default</span>
                        <p class="text-gray-900 font-medium">Rp {{ number_format($medicine->default_purchase_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Harga Jual</span>
                        <p class="text-gray-900 font-medium">Rp {{ number_format($medicine->selling_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Stok Saat Ini</span>
                        <p class="font-bold text-lg {{ $medicine->stock <= $medicine->minimum_stock ? 'text-red-600' : 'text-green-600' }}">
                            {{ $medicine->stock }}
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Stok Minimum</span>
                        <p class="text-gray-900 font-medium">{{ $medicine->minimum_stock }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <span class="text-sm text-gray-500">Deskripsi</span>
                        <p class="text-gray-900">{{ $medicine->description ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Batches Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Daftar Batch</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Batch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expired</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Beli</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty Awal</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($medicine->batches as $batch)
                                @php
                                    $expired = \Carbon\Carbon::parse($batch->expired_date);
                                    $now = now();
                                    $isExpired = $expired->isPast();
                                    $isNearExpiry = !$isExpired && (int) $expired->diffInDays($now) <= 30;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $batch->batch_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium
                                        {{ $isExpired ? 'text-red-600' : ($isNearExpiry ? 'text-orange-500' : 'text-gray-900') }}">
                                        {{ $expired->format('d/m/Y') }}
                                        @if($isExpired)
                                            <span class="ml-1 text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded-full">Expired</span>
                                        @elseif($isNearExpiry)
                                            <span class="ml-1 text-xs bg-orange-100 text-orange-800 px-2 py-0.5 rounded-full">Segera Expired</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($batch->purchase_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $batch->initial_quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-semibold">{{ $batch->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada batch untuk obat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
