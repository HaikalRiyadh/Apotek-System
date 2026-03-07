<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">
                        💊 Apotek Kita Sehat
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @can('view medicines')
                    <x-nav-link :href="route('medicines.index')" :active="request()->routeIs('medicines.*')">
                        Obat
                    </x-nav-link>
                    @endcan

                    @can('manage categories')
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        Kategori
                    </x-nav-link>
                    @endcan

                    @can('manage units')
                    <x-nav-link :href="route('units.index')" :active="request()->routeIs('units.*')">
                        Satuan
                    </x-nav-link>
                    @endcan

                    @can('view suppliers')
                    <x-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                        Supplier
                    </x-nav-link>
                    @endcan

                    @can('view purchases')
                    <x-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')">
                        Pembelian
                    </x-nav-link>
                    @endcan

                    @can('create sales')
                    <x-nav-link :href="route('sales.create')" :active="request()->routeIs('sales.create')">
                        POS
                    </x-nav-link>
                    @endcan

                    @can('view sales')
                    <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
                        Penjualan
                    </x-nav-link>
                    @endcan

                    @can('view reports')
                    <div x-data="{ reportOpen: false }" class="relative flex items-center">
                        <button @click="reportOpen = !reportOpen" @click.outside="reportOpen = false"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition">
                            Laporan
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="reportOpen" x-transition class="absolute top-full left-0 mt-1 w-48 bg-white rounded-md shadow-lg border z-50">
                            <a href="{{ route('reports.sales') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Laporan Penjualan</a>
                            <a href="{{ route('reports.purchases') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Laporan Pembelian</a>
                            <a href="{{ route('reports.stock') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Laporan Stok</a>
                            <a href="{{ route('reports.expiring') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Obat Hampir Expired</a>
                            <a href="{{ route('reports.gross-profit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Laba Kotor</a>
                        </div>
                    </div>
                    @endcan

                    @role('Admin')
                    <x-nav-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.*')">
                        Log Aktivitas
                    </x-nav-link>
                    @endrole
                </div>
            </div>

            <!-- Notification Bell & Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notification Bell -->
                <div x-data="{ notifOpen: false }" class="relative mr-3">
                    <button @click="notifOpen = !notifOpen" @click.outside="notifOpen = false"
                        class="relative inline-flex items-center p-2 text-gray-500 hover:text-gray-700 focus:outline-none transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <div x-show="notifOpen" x-transition class="absolute right-0 mt-1 w-80 bg-white rounded-md shadow-lg border z-50 max-h-96 overflow-y-auto">
                        <div class="px-4 py-3 border-b bg-gray-50 flex justify-between items-center">
                            <span class="font-semibold text-sm text-gray-700">Notifikasi</span>
                            <a href="{{ route('notifications.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800">Lihat semua</a>
                        </div>
                        @forelse(auth()->user()->notifications->take(5) as $notification)
                            <div class="px-4 py-3 border-b {{ $notification->read_at ? 'bg-white' : 'bg-indigo-50' }} hover:bg-gray-50">
                                <div class="flex items-start gap-2">
                                    @if($notification->data['type'] === 'low_stock')
                                        <span class="text-red-500 mt-0.5">⚠️</span>
                                    @else
                                        <span class="text-orange-500 mt-0.5">⏰</span>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $notification->data['title'] }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $notification->data['message'] }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-6 text-center text-sm text-gray-400">Tidak ada notifikasi</div>
                        @endforelse
                    </div>
                </div>

                <span class="text-xs text-gray-400 mr-3">{{ Auth::user()->roles->pluck('name')->first() }}</span>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            @can('view medicines')
            <x-responsive-nav-link :href="route('medicines.index')">Obat</x-responsive-nav-link>
            @endcan
            @can('manage categories')
            <x-responsive-nav-link :href="route('categories.index')">Kategori</x-responsive-nav-link>
            @endcan
            @can('manage units')
            <x-responsive-nav-link :href="route('units.index')">Satuan</x-responsive-nav-link>
            @endcan
            @can('view suppliers')
            <x-responsive-nav-link :href="route('suppliers.index')">Supplier</x-responsive-nav-link>
            @endcan
            @can('view purchases')
            <x-responsive-nav-link :href="route('purchases.index')">Pembelian</x-responsive-nav-link>
            @endcan
            @can('create sales')
            <x-responsive-nav-link :href="route('sales.create')">POS</x-responsive-nav-link>
            @endcan
            @can('view sales')
            <x-responsive-nav-link :href="route('sales.index')">Penjualan</x-responsive-nav-link>
            @endcan
            @can('view reports')
            <x-responsive-nav-link :href="route('reports.sales')">Lap. Penjualan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.purchases')">Lap. Pembelian</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.stock')">Lap. Stok</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.expiring')">Obat Hampir Expired</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.gross-profit')">Laba Kotor</x-responsive-nav-link>
            @endcan
            @role('Admin')
            <x-responsive-nav-link :href="route('activity-logs.index')">Log Aktivitas</x-responsive-nav-link>
            @endrole
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
