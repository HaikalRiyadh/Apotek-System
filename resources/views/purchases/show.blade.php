<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pembelian: {{ $purchase->invoice_number }}</h2>
            <a href="{{ route('purchases.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informasi Pembelian -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Informasi Pembelian</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-500">No Invoice</span>
                        <p class="text-gray-900 font-medium">{{ $purchase->invoice_number }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Supplier</span>
                        <p class="text-gray-900 font-medium">{{ $purchase->supplier->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Tanggal</span>
                        <p class="text-gray-900 font-medium">{{ $purchase->purchase_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Total</span>
                        <p class="text-gray-900 font-bold text-lg">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Catatan</span>
                        <p class="text-gray-900">{{ $purchase->notes ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">User</span>
                        <p class="text-gray-900 font-medium">{{ $purchase->user->name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Item -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Detail Item</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obat</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Beli</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Batch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expired</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($purchase->details as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->medicine->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ $detail->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($detail->purchase_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->batch_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($detail->expired_date)
                                            <span class="{{ $detail->expired_date->isPast() ? 'text-red-600 font-semibold' : '' }}">
                                                {{ $detail->expired_date->format('d/m/Y') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada detail item.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-700 uppercase">Total</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
