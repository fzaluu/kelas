

<?php $__env->startSection('title', 'Kelola Anggota Kelas - XI PPLG 2'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Anggota Kelas</h1>
            <p class="text-xs text-slate-500">Pusat data identitas siswa (Single Source of Truth) kelas XI PPLG 2.</p>
        </div>

        <a href="<?php echo e(route('development.members.create')); ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shrink-0">
            + Tambah Anggota Kelas
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">NIS / NISN</th>
                        <th class="p-4">L/P</th>
                        <th class="p-4">Status Akun</th>
                        <th class="p-4">Status Anggota</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <div class="font-bold text-slate-900"><?php echo e($m->name); ?></div>
                                <div class="text-[10px] text-slate-400"><?php echo e($m->schoolClass->name ?? 'XI PPLG 2'); ?></div>
                            </td>
                            <td class="p-4 font-mono text-slate-700">
                                <div>NIS: <?php echo e($m->nis ?? '-'); ?></div>
                                <div class="text-[10px] text-slate-400">NISN: <?php echo e($m->nisn ?? '-'); ?></div>
                            </td>
                            <td class="p-4 font-bold"><?php echo e($m->gender); ?></td>
                            <td class="p-4">
                                <?php if($m->user): ?>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        Terhubung (<?php echo e($m->user->username); ?>)
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-500">
                                        Belum Ada Akun
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold <?php echo e($m->member_status === 'ACTIVE' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'); ?>">
                                    <?php echo e($m->member_status); ?>

                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="<?php echo e(route('development.members.edit', $m->id)); ?>" class="font-bold text-blue-600 hover:underline">Edit</a>
                                <form action="<?php echo e(route('development.members.destroy', $m->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus data anggota ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="font-bold text-rose-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">Belum ada data anggota kelas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($members->hasPages()): ?>
            <div class="p-4 border-t border-slate-100">
                <?php echo e($members->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/members/index.blade.php ENDPATH**/ ?>