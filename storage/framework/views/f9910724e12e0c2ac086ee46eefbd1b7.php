<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Apotek Kita Sehat')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>body { font-family: 'Inter', sans-serif; } [x-cloak] { display: none !important; }</style>
        <?php echo $__env->yieldPushContent('styles'); ?>
    </head>
    <body class="antialiased bg-slate-50" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex">
            
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            
            <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-cloak></div>

            
            <div class="main-content flex-1 min-h-screen flex flex-col">
                
                <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-lg border-b border-slate-200/60">
                    <div class="flex items-center justify-between px-6 py-3.5">
                        <div class="flex items-center gap-4">
                            
                            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </button>

                            
                            <?php if(isset($header)): ?>
                                <div><?php echo e($header); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="flex items-center gap-3">
                            
                            <span class="hidden md:block text-xs text-slate-400 font-medium"><?php echo e(now()->translatedFormat('l, d F Y')); ?></span>

                            
                            <div x-data="{ notifOpen: false }" class="relative">
                                <button @click="notifOpen = !notifOpen" @click.outside="notifOpen = false"
                                    class="relative p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-all duration-200">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                                        <span class="absolute -top-0.5 -right-0.5 w-5 h-5 flex items-center justify-center text-[10px] font-bold text-white bg-red-500 rounded-full ring-2 ring-white">
                                            <?php echo e(auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count()); ?>

                                        </span>
                                    <?php endif; ?>
                                </button>

                                <div x-show="notifOpen" x-transition x-cloak
                                     class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-200/60 z-50 overflow-hidden">
                                    <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                                        <span class="font-semibold text-sm text-slate-700">Notifikasi</span>
                                        <a href="<?php echo e(route('notifications.index')); ?>" class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold">Lihat semua</a>
                                    </div>
                                    <div class="max-h-80 overflow-y-auto">
                                        <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <div class="px-5 py-3.5 border-b border-slate-50 <?php echo e($notification->read_at ? 'bg-white' : 'bg-emerald-50/40'); ?> hover:bg-slate-50/80 transition-colors">
                                                <div class="flex items-start gap-3">
                                                    <?php if($notification->data['type'] === 'low_stock'): ?>
                                                        <span class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        </span>
                                                    <?php endif; ?>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-slate-700 truncate"><?php echo e($notification->data['title']); ?></p>
                                                        <p class="text-xs text-slate-500 truncate mt-0.5"><?php echo e($notification->data['message']); ?></p>
                                                        <p class="text-xs text-slate-400 mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <div class="px-5 py-8 text-center">
                                                <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                                <p class="text-sm text-slate-400">Tidak ada notifikasi</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            
                            <div x-data="{ userOpen: false }" class="relative">
                                <button @click="userOpen = !userOpen" @click.outside="userOpen = false"
                                    class="flex items-center gap-3 pl-3 pr-2 py-1.5 rounded-xl hover:bg-slate-100 transition-all duration-200">
                                    <div class="text-right hidden sm:block">
                                        <div class="text-sm font-semibold text-slate-700"><?php echo e(Auth::user()->name); ?></div>
                                        <div class="text-xs text-slate-400"><?php echo e(Auth::user()->roles->pluck('name')->first()); ?></div>
                                    </div>
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-sm font-bold shadow-sm">
                                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                                    </div>
                                </button>

                                <div x-show="userOpen" x-transition x-cloak
                                     class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200/60 z-50 overflow-hidden py-2">
                                    <div class="px-4 py-3 border-b border-slate-100">
                                        <p class="text-sm font-semibold text-slate-700"><?php echo e(Auth::user()->name); ?></p>
                                        <p class="text-xs text-slate-400 truncate"><?php echo e(Auth::user()->email); ?></p>
                                    </div>
                                    <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Profil Saya
                                    </a>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Flash Messages (SweetAlert) -->
                <?php if(session('success')): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: <?php echo \Illuminate\Support\Js::from(session('success'))->toHtml() ?>,
                                timer: 3000,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end',
                                customClass: { popup: 'rounded-2xl' }
                            });
                        });
                    </script>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: <?php echo \Illuminate\Support\Js::from(session('error'))->toHtml() ?>,
                                confirmButtonColor: '#10b981',
                                customClass: { popup: 'rounded-2xl' }
                            });
                        });
                    </script>
                <?php endif; ?>

                <!-- Page Content -->
                <main class="flex-1 p-6">
                    <?php echo e($slot); ?>

                </main>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.delete-form').forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: 'Data yang dihapus tidak dapat dikembalikan!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            customClass: { popup: 'rounded-2xl' }
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>
<?php /**PATH C:\laragon\www\Apotek_system\resources\views/layouts/app.blade.php ENDPATH**/ ?>