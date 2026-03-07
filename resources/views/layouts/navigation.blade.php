{{-- Professional Sidebar Navigation --}}
<aside :class="sidebarOpen ? 'sidebar mobile-open' : 'sidebar'"
       class="flex flex-col" x-cloak>

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
        <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 flex-shrink-0">
            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 2a1 1 0 00-1 1v6H3a1 1 0 00-1 1v4a1 1 0 001 1h6v6a1 1 0 001 1h4a1 1 0 001-1v-6h6a1 1 0 001-1v-4a1 1 0 00-1-1h-6V3a1 1 0 00-1-1h-4z"/>
            </svg>
        </div>
        <div class="overflow-hidden">
            <h1 class="text-white font-bold text-sm tracking-tight truncate">Apotek Kita Sehat</h1>
            <p class="text-slate-400 text-[10px] font-medium">Pharmacy Management</p>
        </div>
        {{-- Mobile Close --}}
        <button @click="sidebarOpen = false" class="lg:hidden ml-auto p-1 text-slate-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-1 overflow-y-auto py-4 space-y-1">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/></svg>
            <span>Dashboard</span>
        </a>

        {{-- Master Data Section --}}
        <div class="px-5 pt-5 pb-2">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Master Data</p>
        </div>

        @can('view medicines')
        <a href="{{ route('medicines.index') }}"
           class="sidebar-link {{ request()->routeIs('medicines.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            <span>Obat</span>
        </a>
        @endcan

        @can('manage categories')
        <a href="{{ route('categories.index') }}"
           class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            <span>Kategori</span>
        </a>
        @endcan

        @can('manage units')
        <a href="{{ route('units.index') }}"
           class="sidebar-link {{ request()->routeIs('units.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span>Satuan</span>
        </a>
        @endcan

        @can('view suppliers')
        <a href="{{ route('suppliers.index') }}"
           class="sidebar-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span>Supplier</span>
        </a>
        @endcan

        {{-- Transaction Section --}}
        <div class="px-5 pt-5 pb-2">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Transaksi</p>
        </div>

        @can('create sales')
        <a href="{{ route('sales.create') }}"
           class="sidebar-link {{ request()->routeIs('sales.create') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            <span>POS / Kasir</span>
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-emerald-500/20 text-emerald-400 rounded-md">NEW</span>
        </a>
        @endcan

        @can('view sales')
        <a href="{{ route('sales.index') }}"
           class="sidebar-link {{ request()->routeIs('sales.index') || request()->routeIs('sales.show') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
            <span>Penjualan</span>
        </a>
        @endcan

        @can('view purchases')
        <a href="{{ route('purchases.index') }}"
           class="sidebar-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <span>Pembelian</span>
        </a>
        @endcan

        @can('edit medicines')
        <a href="{{ route('stock-adjustments.index') }}"
           class="sidebar-link {{ request()->routeIs('stock-adjustments.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <span>Penyesuaian Stok</span>
        </a>
        @endcan

        {{-- Reports Section --}}
        @can('view reports')
        <div class="px-5 pt-5 pb-2">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Laporan</p>
        </div>

        <div x-data="{ reportExpand: {{ request()->routeIs('reports.*') ? 'true' : 'false' }} }">
            <button @click="reportExpand = !reportExpand"
                class="sidebar-link w-full {{ request()->routeIs('reports.*') ? 'text-emerald-400' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Laporan</span>
                <svg :class="reportExpand ? 'rotate-180' : ''" class="w-4 h-4 ml-auto transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div x-show="reportExpand" x-collapse x-cloak class="mt-1 space-y-0.5 ml-5 border-l border-white/10 pl-3">
                <a href="{{ route('reports.sales') }}" class="sidebar-link !mx-0 !px-3 text-xs {{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('reports.sales') ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
                    <span>Penjualan</span>
                </a>
                <a href="{{ route('reports.purchases') }}" class="sidebar-link !mx-0 !px-3 text-xs {{ request()->routeIs('reports.purchases') ? 'active' : '' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('reports.purchases') ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
                    <span>Pembelian</span>
                </a>
                <a href="{{ route('reports.stock') }}" class="sidebar-link !mx-0 !px-3 text-xs {{ request()->routeIs('reports.stock') ? 'active' : '' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('reports.stock') ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
                    <span>Stok Obat</span>
                </a>
                <a href="{{ route('reports.expiring') }}" class="sidebar-link !mx-0 !px-3 text-xs {{ request()->routeIs('reports.expiring') ? 'active' : '' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('reports.expiring') ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
                    <span>Hampir Expired</span>
                </a>
                <a href="{{ route('reports.gross-profit') }}" class="sidebar-link !mx-0 !px-3 text-xs {{ request()->routeIs('reports.gross-profit') ? 'active' : '' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('reports.gross-profit') ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
                    <span>Laba Kotor</span>
                </a>
            </div>
        </div>
        @endcan

        {{-- System Section --}}
        @role('Admin')
        <div class="px-5 pt-5 pb-2">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sistem</p>
        </div>

        <a href="{{ route('activity-logs.index') }}"
           class="sidebar-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Log Aktivitas</span>
        </a>
        @endrole
    </nav>

    {{-- User Info at Bottom --}}
    <div class="border-t border-white/10 p-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->roles->pluck('name')->first() }}</p>
            </div>
        </div>
    </div>
</aside>
