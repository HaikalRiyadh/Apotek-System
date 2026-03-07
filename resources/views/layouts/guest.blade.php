<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Apotek Kita Sehat') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            {{-- Left Branding Panel --}}
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 flex-col justify-between p-12 relative overflow-hidden">
                {{-- Decorative circles --}}
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-white opacity-5 rounded-full"></div>
                <div class="absolute -bottom-32 -right-16 w-80 h-80 bg-white opacity-5 rounded-full"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white opacity-5 rounded-full"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center text-2xl">💊</div>
                        <span class="text-white text-xl font-bold">Apotek Kita Sehat</span>
                    </div>
                    <p class="text-indigo-200 text-sm">Sistem Manajemen Apotek Terintegrasi</p>
                </div>

                <div class="relative z-10 space-y-6">
                    <div>
                        <h2 class="text-white text-3xl font-bold leading-tight mb-3">Kelola Apotek Anda<br>Lebih Mudah & Efisien</h2>
                        <p class="text-indigo-200 text-sm leading-relaxed">
                            Platform manajemen apotek lengkap dengan fitur POS, stok obat, laporan keuangan, dan notifikasi otomatis untuk menjaga kualitas layanan Anda.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white bg-opacity-10 rounded-xl p-4">
                            <div class="text-2xl mb-1">🛒</div>
                            <div class="text-white text-sm font-medium">Point of Sale</div>
                            <div class="text-indigo-200 text-xs mt-0.5">Transaksi cepat & akurat</div>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-xl p-4">
                            <div class="text-2xl mb-1">📦</div>
                            <div class="text-white text-sm font-medium">Manajemen Stok</div>
                            <div class="text-indigo-200 text-xs mt-0.5">Pantau stok real-time</div>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-xl p-4">
                            <div class="text-2xl mb-1">📊</div>
                            <div class="text-white text-sm font-medium">Laporan Lengkap</div>
                            <div class="text-indigo-200 text-xs mt-0.5">Analisis bisnis mudah</div>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-xl p-4">
                            <div class="text-2xl mb-1">🔔</div>
                            <div class="text-white text-sm font-medium">Notifikasi Otomatis</div>
                            <div class="text-indigo-200 text-xs mt-0.5">Stok rendah & expired</div>
                        </div>
                    </div>
                </div>

                <div class="relative z-10">
                    <p class="text-indigo-300 text-xs">&copy; {{ date('Y') }} Apotek Kita Sehat. All rights reserved.</p>
                </div>
            </div>

            {{-- Right Form Panel --}}
            <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50">
                {{-- Mobile Logo --}}
                <div class="lg:hidden flex items-center gap-2 mb-8">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-xl">💊</div>
                    <span class="text-indigo-700 text-lg font-bold">Apotek Kita Sehat</span>
                </div>

                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>

                <p class="mt-8 text-xs text-gray-400 text-center lg:hidden">&copy; {{ date('Y') }} Apotek Kita Sehat</p>
            </div>
        </div>
    </body>
</html>
