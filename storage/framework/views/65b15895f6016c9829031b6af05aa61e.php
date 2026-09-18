

<?php $__env->startSection('title', 'Activity Logs - XI PPLG 2'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Activity Logs</h1>
            <p class="text-xs text-slate-500">Jejak audit dan riwayat aktivitas pengguna pada platform.</p>
        </div>

        <!-- Filter Form -->
        <form action="<?php echo e(route('development.activity-logs.index')); ?>" method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari aksi / user..." class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white">
            <select name="result" class="px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white">
                <option value="">Semua Status</option>
                <option value="SUCCESS" <?php echo e(request('result') === 'SUCCESS' ? 'selected' : ''); ?>>SUCCESS</option>
                <option value="FAILED" <?php echo e(request('result') === 'FAILED' ? 'selected' : ''); ?>>FAILED</option>
                <option value="FORBIDDEN" <?php echo e(request('result') === 'FORBIDDEN' ? 'selected' : ''); ?>>FORBIDDEN</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition">Filter</button>
        </form>
    </div>

    <!-- Log Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Aktor</th>
                        <th class="py-3 px-4">Aksi</th>
                        <th class="py-3 px-4">Resource</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-4 font-mono text-[11px] text-slate-500">
                                <?php echo e($log->created_at ? $log->created_at->format('Y-m-d H:i:s') : '-'); ?>

                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-900">
                                <?php echo e($log->actor->username ?? 'System/Guest'); ?>

                            </td>
                            <td class="py-3 px-4 font-medium text-blue-600">
                                <?php echo e($log->action); ?>

                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-mono">
                                    <?php echo e($log->resource_type); ?> #<?php echo e($log->resource_id ?? '-'); ?>

                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <?php if($log->result === 'SUCCESS'): ?>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">SUCCESS</span>
                                <?php elseif($log->result === 'FAILED'): ?>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">FAILED</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">FORBIDDEN</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 font-mono text-[11px] text-slate-400">
                                <?php echo e($log->ip ?? '127.0.0.1'); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada riwayat aktivitas tercatat.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <?php echo e($logs->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/activity-logs/index.blade.php ENDPATH**/ ?>