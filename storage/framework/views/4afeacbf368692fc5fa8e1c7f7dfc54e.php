

<?php $__env->startSection('title', 'Manajemen Role & Permission'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-xl font-bold text-slate-900">Modul Role & Hak Akses (RBAC)</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola peranan sistem dan atur pemetaan izin (permissions) untuk tiap role.</p>
    </div>

    <!-- Alert Notifikasi Session -->
    <?php if(session('success')): ?>
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Grid Card Roles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-blue-50 text-blue-700 uppercase border border-blue-200">
                        <?php echo e($role->slug); ?>

                    </span>
                    <span class="text-[10px] text-slate-400 font-bold">
                        <?php echo e($role->permissions->count()); ?> Permission
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900"><?php echo e($role->name); ?></h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    <?php echo e($role->description ?? 'Tidak ada deskripsi role.'); ?>

                </p>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                <?php if($role->slug === 'development'): ?>
                    <span class="w-full text-center text-[10px] font-bold text-amber-700 bg-amber-50 py-2 rounded-xl border border-amber-200">
                        Master Role (Absolut)
                    </span>
                <?php else: ?>
                    <a href="<?php echo e(route('development.roles.edit', $role->id)); ?>" class="w-full text-center px-3 py-2 rounded-xl bg-slate-100 hover:bg-blue-600 text-slate-700 hover:text-white font-bold text-xs transition">
                        Kelola Permission
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/roles/index.blade.php ENDPATH**/ ?>