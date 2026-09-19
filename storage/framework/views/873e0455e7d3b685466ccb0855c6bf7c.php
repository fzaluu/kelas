

<?php $__env->startSection('title', 'Kelola Galeri Kegiatan - XI PPLG 2'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Galeri Foto Kegiatan</h1>
            <p class="text-xs text-slate-500">Kelola dokumentasi visual dan momen kegiatan kelas XI PPLG 2.</p>
        </div>

        <a href="<?php echo e(route('development.public.galleries.create')); ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shrink-0 self-start sm:self-auto">
            TAMBAH FOTO GALERI
        </a>
    </div>

    <!-- Tab Sub-Menu Konten Publik -->
    <div class="flex items-center space-x-2 border-b border-slate-200 overflow-x-auto pb-2">
        <a href="<?php echo e(route('development.public.announcements.index')); ?>" 
           class="px-4 py-2 rounded-xl text-xs font-bold transition <?php echo e(request()->routeIs('development.public.announcements.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100'); ?>">
            Pengumuman
        </a>
        
        <a href="<?php echo e(route('development.public.agendas.index')); ?>" 
           class="px-4 py-2 rounded-xl text-xs font-bold transition <?php echo e(request()->routeIs('development.public.agendas.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100'); ?>">
            Agenda
        </a>
        
        <a href="<?php echo e(route('development.public.documents.index')); ?>" 
           class="px-4 py-2 rounded-xl text-xs font-bold transition <?php echo e(request()->routeIs('development.public.documents.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100'); ?>">
            Dokumentasi
        </a>
        
        <a href="<?php echo e(route('development.public.galleries.index')); ?>" 
           class="px-4 py-2 rounded-xl text-xs font-bold transition <?php echo e(request()->routeIs('development.public.galleries.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100'); ?>">
            Galeri Kegiatan
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Grid Foto Galeri -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $filePath = optional($item->mediaFile)->storage_path ?? optional($item->mediaFile)->file_path;
            ?>
            <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-3 hover:shadow-md transition">
                <div>
                    <!-- Preview Foto -->
                    <div class="w-full h-28 bg-slate-100 rounded-xl overflow-hidden flex items-center justify-center relative">
                        <?php if($filePath): ?>
                            <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($filePath)); ?>" alt="<?php echo e($item->title); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="text-[10px] text-slate-400 font-bold">No Image</span>
                        <?php endif; ?>
                    </div>

                    <!-- Judul & Kategori -->
                    <div class="mt-2 space-y-1">
                        <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-blue-50 text-blue-700 uppercase border border-blue-200/60 inline-block">
                            <?php echo e($item->category); ?>

                        </span>
                        <p class="text-xs font-bold text-slate-800 truncate" title="<?php echo e($item->title); ?>">
                            <?php echo e($item->title); ?>

                        </p>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[10px]">
                    <span class="font-bold <?php echo e($item->status === 'PUBLISHED' ? 'text-emerald-600' : 'text-amber-600'); ?>">
                        <?php echo e($item->status); ?>

                    </span>

                    <form action="<?php echo e(route('development.public.galleries.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="font-bold text-rose-600 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                Belum ada foto kegiatan di galeri.
            </div>
        <?php endif; ?>
    </div>

    <div><?php echo e($galleries->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/public/galleries/index.blade.php ENDPATH**/ ?>