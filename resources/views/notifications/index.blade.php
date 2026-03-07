<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notifikasi</h2>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-800">
                        Tandai semua sudah dibaca
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @forelse($notifications as $notification)
                <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-3 border-l-4 {{ $notification->read_at ? 'border-gray-300' : 'border-indigo-500' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                @if($notification->data['type'] === 'low_stock')
                                    <span class="text-red-500 text-lg">⚠️</span>
                                @elseif($notification->data['type'] === 'expiring_medicine')
                                    <span class="text-orange-500 text-lg">⏰</span>
                                @endif
                                <h4 class="font-semibold text-gray-800">{{ $notification->data['title'] }}</h4>
                                @if(!$notification->read_at)
                                    <span class="px-2 py-0.5 text-xs bg-indigo-100 text-indigo-700 rounded-full">Baru</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $notification->data['message'] }}</p>

                            @if($notification->data['type'] === 'low_stock' && isset($notification->data['medicines']))
                                <div class="mt-2 text-xs text-gray-500">
                                    @foreach(array_slice($notification->data['medicines'], 0, 5) as $med)
                                        <span class="inline-block bg-red-50 text-red-700 px-2 py-0.5 rounded mr-1 mb-1">
                                            {{ $med['name'] }} (stok: {{ $med['stock_total'] }})
                                        </span>
                                    @endforeach
                                    @if(count($notification->data['medicines']) > 5)
                                        <span class="text-gray-400">+{{ count($notification->data['medicines']) - 5 }} lainnya</span>
                                    @endif
                                </div>
                            @endif

                            @if($notification->data['type'] === 'expiring_medicine' && isset($notification->data['batches']))
                                <div class="mt-2 text-xs text-gray-500">
                                    @foreach(array_slice($notification->data['batches'], 0, 5) as $batch)
                                        <span class="inline-block bg-orange-50 text-orange-700 px-2 py-0.5 rounded mr-1 mb-1">
                                            {{ $batch['medicine_name'] }} ({{ $batch['batch_number'] }}, exp: {{ $batch['expired_date'] }})
                                        </span>
                                    @endforeach
                                    @if(count($notification->data['batches']) > 5)
                                        <span class="text-gray-400">+{{ count($notification->data['batches']) - 5 }} lainnya</span>
                                    @endif
                                </div>
                            @endif

                            <div class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>

                        @if(!$notification->read_at)
                            <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 ml-3" title="Tandai sudah dibaca">
                                    ✓
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-sm sm:rounded-lg p-8 text-center text-gray-500">
                    <div class="text-4xl mb-2">🔔</div>
                    <p>Belum ada notifikasi.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
