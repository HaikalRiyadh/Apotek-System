<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Apotek Kita Sehat') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
            .login-float-1 { animation: float 18s ease-in-out infinite; }
            .login-float-2 { animation: float 22s ease-in-out infinite reverse; }
            .login-float-3 { animation: float 15s ease-in-out infinite 2s; }
            .mesh-gradient {
                background:
                    radial-gradient(ellipse at 20% 50%, rgba(16, 185, 129, 0.15) 0%, transparent 50%),
                    radial-gradient(ellipse at 80% 20%, rgba(6, 182, 212, 0.1) 0%, transparent 50%),
                    radial-gradient(ellipse at 60% 80%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                    linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex">
            {{-- Left Branding Panel --}}
            <div class="hidden lg:flex lg:w-[55%] mesh-gradient flex-col justify-between p-12 relative overflow-hidden">
                {{-- Floating decorative shapes --}}
                <div class="floating-shape login-float-1 w-72 h-72 bg-emerald-500 -top-12 -left-12"></div>
                <div class="floating-shape login-float-2 w-96 h-96 bg-cyan-500 -bottom-24 -right-24"></div>
                <div class="floating-shape login-float-3 w-48 h-48 bg-indigo-500 top-1/2 left-1/3"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-transparent via-slate-900/50 to-slate-900/80"></div>

                {{-- Top Branding --}}
                <div class="relative z-10 animate-fade-in">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-11 h-11 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 2a1 1 0 00-1 1v6H3a1 1 0 00-1 1v4a1 1 0 001 1h6v6a1 1 0 001 1h4a1 1 0 001-1v-6h6a1 1 0 001-1v-4a1 1 0 00-1-1h-6V3a1 1 0 00-1-1h-4z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-white text-lg font-bold tracking-tight">Apotek Kita Sehat</span>
                            <span class="block text-emerald-400/80 text-xs font-medium">Pharmacy Management System</span>
                        </div>
                    </div>
                </div>

                {{-- Middle Content --}}
                <div class="relative z-10 space-y-8 animate-slide-up" style="animation-delay: 0.2s; opacity: 0;">
                    <div>
                        <h2 class="text-white text-4xl font-extrabold leading-tight tracking-tight">
                            Kelola Apotek<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Lebih Cerdas</span>
                        </h2>
                        <p class="text-slate-400 text-sm leading-relaxed mt-4 max-w-md">
                            Platform manajemen apotek terintegrasi dengan fitur Point of Sale, inventaris obat, laporan keuangan, dan notifikasi otomatis untuk menjaga kualitas layanan Anda.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3.5">
                        <div class="glass-card p-4 group hover:bg-white/15 transition-all duration-300">
                            <div class="w-9 h-9 rounded-lg bg-emerald-500/20 flex items-center justify-center mb-2.5 group-hover:bg-emerald-500/30 transition-colors">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                </svg>
                            </div>
                            <div class="text-white text-sm font-semibold">Point of Sale</div>
                            <div class="text-slate-400 text-xs mt-0.5">Transaksi cepat & akurat</div>
                        </div>
                        <div class="glass-card p-4 group hover:bg-white/15 transition-all duration-300">
                            <div class="w-9 h-9 rounded-lg bg-cyan-500/20 flex items-center justify-center mb-2.5 group-hover:bg-cyan-500/30 transition-colors">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="text-white text-sm font-semibold">Manajemen Stok</div>
                            <div class="text-slate-400 text-xs mt-0.5">Pantau stok real-time</div>
                        </div>
                        <div class="glass-card p-4 group hover:bg-white/15 transition-all duration-300">
                            <div class="w-9 h-9 rounded-lg bg-violet-500/20 flex items-center justify-center mb-2.5 group-hover:bg-violet-500/30 transition-colors">
                                <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div class="text-white text-sm font-semibold">Laporan Lengkap</div>
                            <div class="text-slate-400 text-xs mt-0.5">Analisis bisnis mendalam</div>
                        </div>
                        <div class="glass-card p-4 group hover:bg-white/15 transition-all duration-300">
                            <div class="w-9 h-9 rounded-lg bg-amber-500/20 flex items-center justify-center mb-2.5 group-hover:bg-amber-500/30 transition-colors">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <div class="text-white text-sm font-semibold">Notifikasi Otomatis</div>
                            <div class="text-slate-400 text-xs mt-0.5">Peringatan stok & expired</div>
                        </div>
                    </div>
                </div>

                {{-- Bottom --}}
                <div class="relative z-10 flex items-center justify-between">
                    <p class="text-slate-500 text-xs">&copy; {{ date('Y') }} Apotek Kita Sehat. All rights reserved.</p>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-emerald-400 text-xs font-medium">System Online</span>
                    </div>
                </div>
            </div>

            {{-- Right Form Panel --}}
            <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50 relative">
                {{-- Subtle pattern --}}
                <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle, #000 1px, transparent 1px); background-size: 24px 24px;"></div>

                {{-- Mobile Logo --}}
                <div class="lg:hidden flex items-center gap-2.5 mb-10 relative z-10">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 2a1 1 0 00-1 1v6H3a1 1 0 00-1 1v4a1 1 0 001 1h6v6a1 1 0 001 1h4a1 1 0 001-1v-6h6a1 1 0 001-1v-4a1 1 0 00-1-1h-6V3a1 1 0 00-1-1h-4z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-slate-800 text-lg font-bold">Apotek Kita Sehat</span>
                        <span class="block text-slate-400 text-xs">Pharmacy Management System</span>
                    </div>
                </div>

                <div class="w-full max-w-[420px] relative z-10 animate-slide-up">
                    {{ $slot }}
                </div>

                <p class="mt-10 text-xs text-slate-400 text-center lg:hidden relative z-10">&copy; {{ date('Y') }} Apotek Kita Sehat</p>
            </div>
        </div>
    </body>
</html>
