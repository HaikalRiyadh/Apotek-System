<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Notifikasi</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Peringatan stok rendah dan obat kadaluarsa</p>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>
            @forelse($notifications as $notification)
                <div class="card overflow-hidden border-l-4 {{ $notification->read_at ? 'border-l-slate-200' : 'border-l-emerald-500' }}">
                    <div class="card-body">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    @if($notification->data['type'] === 'low_stock')
                                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                        </div>
                                    @elseif($notification->data['type'] === 'expiring_medicine')
                                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-bold text-slate-800">{{ $notification->data['title'] }}</h4>
                                            @if(!$notification->read_at)
                                                <span class="badge badge-success">Baru</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-slate-500 mt-0.5">{{ $notification->data['message'] }}</p>
                                    </div>
                                </div>

                                @if($notification->data['type'] === 'low_stock' && isset($notification->data['medicines']))
                                    <div class="mt-3 flex flex-wrap gap-1.5 ml-13">
                                        @foreach(array_slice($notification->data['medicines'], 0, 5) as $med)
                                            <span class="badge badge-danger">{{ $med['name'] }} (stok: {{ $med['stock_total'] }})</span>
                                        @endforeach
                                        @if(count($notification->data['medicines']) > 5)
                                            <span class="text-xs text-slate-400">+{{ count($notification->data['medicines']) - 5 }} lainnya</span>
                                        @endif
                                    </div>
                                @endif

                                @if($notification->data['type'] === 'expiring_medicine' && isset($notification->data['batches']))
                                    <div class="mt-3 flex flex-wrap gap-1.5 ml-13">
                                        @foreach(array_slice($notification->data['batches'], 0, 5) as $batch)
                                            <span class="badge badge-warning">{{ $batch['medicine_name'] }} ({{ $batch['batch_number'] }}, exp: {{ $batch['expired_date'] }})</span>
                                        @endforeach
                                        @if(count($notification->data['batches']) > 5)
                                            <span class="text-xs text-slate-400">+{{ count($notification->data['batches']) - 5 }} lainnya</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="text-xs text-slate-400 mt-3 ml-13">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>

                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}">
                                    @csrf
                                    <button type="submit" class="btn-icon-sm bg-emerald-50 text-emerald-500 hover:bg-emerald-100" title="Tandai sudah dibaca">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body py-16 text-center">
                        <svg class="w-20 h-20 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <p class="text-slate-400">Belum ada notifikasi.</p>
                    </div>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
</x-app-layout>
