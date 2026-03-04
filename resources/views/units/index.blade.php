<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Daftar Satuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-medium">Satuan</h3>
                        <a href="{{ route('units.create') }}"
                           class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                            Tambah Satuan
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">No</th>
                                    <th class="border px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
                                    <th class="border px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Singkatan</th>
                                    <th class="border px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Jumlah Obat</th>
                                    <th class="border px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($units as $unit)
                                    <tr>
                                        <td class="border px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + ($units->currentPage() - 1) * $units->perPage() }}</td>
                                        <td class="border px-4 py-3 text-sm text-gray-700">{{ $unit->name }}</td>
                                        <td class="border px-4 py-3 text-sm text-gray-700">{{ $unit->abbreviation }}</td>
                                        <td class="border px-4 py-3 text-sm text-gray-700">{{ $unit->medicines_count ?? $unit->medicines->count() }}</td>
                                        <td class="border px-4 py-3 text-sm">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('units.edit', $unit) }}"
                                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                                <form action="{{ route('units.destroy', $unit) }}" method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus satuan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border px-4 py-3 text-center text-sm text-gray-500">
                                            Belum ada data satuan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $units->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
