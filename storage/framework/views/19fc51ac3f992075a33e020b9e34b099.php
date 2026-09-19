

<?php $__env->startSection('title', 'Kelola Karya Siswa - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Karya & Project Showcase</h1>
            <p class="text-xs text-slate-500">Kelola portfolio dan karya buatan siswa XI PPLG 2.</p>
        </div>
        <a href="<?php echo e(route('development.content.projects.create')); ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">+ TAMBAH KARYA</a>
    </div>

    <?php if(session('success')): ?>
        <div class="p-3.5 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-semibold"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $media = $item->projectMedia->first()?->mediaFile; ?>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
                <div class="space-y-2">
                    <div class="h-32 bg-slate-100 rounded-xl overflow-hidden">
                        <?php if($media): ?> <img src="<?php echo e($media->url); ?>" class="w-full h-full object-cover"> <?php endif; ?>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900 truncate"><?php echo e($item->title); ?></h3>
                    <p class="text-xs text-slate-500 line-clamp-2"><?php echo e($item->description); ?></p>
                </div>
                <div class="pt-2 border-t flex justify-between items-center text-[10px]">
                    <span class="font-bold text-emerald-600"><?php echo e($item->status); ?></span>
                    <form action="<?php echo e(route('development.content.projects.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Hapus karya ini?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-rose-600 font-bold hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-8 text-xs text-slate-400">Belum ada karya siswa yang tersimpan.</div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/public/content/projects/index.blade.php ENDPATH**/ ?>