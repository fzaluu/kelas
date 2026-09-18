

<?php $__env->startSection('title', 'Pengaturan Sistem & Alert - XI PPLG 2'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pengaturan Sistem & Alert</h1>
        <p class="text-xs text-slate-500">Konfigurasi pesan pengumuman global, jam operasional absensi, dan mode pemeliharaan.</p>
    </div>

    <?php if(session('success')): ?>
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('development.system.settings.update')); ?>" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
        <?php echo csrf_field(); ?>

        <!-- Broadcast System Alert -->
        <div class="space-y-3 pb-4 border-b border-slate-100">
            <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">📢 System Alert / Banner Pengumuman</h3>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pesan Alert Global</label>
                <textarea name="system_alert" rows="3" placeholder="Tuliskan pengumuman penting yang akan tampil di atas halaman portal..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 transition"><?php echo e($settings['system_alert']); ?></textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Alert Banner</label>
                <select name="alert_status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white">
                    <option value="DISABLED" <?php echo e($settings['alert_status'] === 'DISABLED' ? 'selected' : ''); ?>>NONAKTIF (Sembunyikan Banner)</option>
                    <option value="ENABLED" <?php echo e($settings['alert_status'] === 'ENABLED' ? 'selected' : ''); ?>>AKTIF (Tampilkan di Atas Website)</option>
                </select>
            </div>
        </div>

        <!-- Jam Presensi / Absensi -->
        <div class="space-y-3 pb-4 border-b border-slate-100">
            <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">⏰ Waktu Operasional Presensi QR</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jam Buka Absen</label>
                    <input type="time" name="attendance_open" value="<?php echo e($settings['attendance_open']); ?>" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jam Tutup Absen</label>
                    <input type="time" name="attendance_close" value="<?php echo e($settings['attendance_close']); ?>" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
                </div>
            </div>
        </div>

        <!-- Mode Pemeliharaan -->
        <div class="space-y-3">
            <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">🛠️ Mode Maintenance Portal</h3>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Maintenance</label>
                <select name="maintenance_mode" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white">
                    <option value="OFF" <?php echo e($settings['maintenance_mode'] === 'OFF' ? 'selected' : ''); ?>>OFF (Portal Berjalan Normal)</option>
                    <option value="ON" <?php echo e($settings['maintenance_mode'] === 'ON' ? 'selected' : ''); ?>>ON (Portal Dalam Pemeliharaan)</option>
                </select>
            </div>
        </div>

        <div class="pt-3 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-600/20">
                SIMPAN PENGATURAN
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/system/settings.blade.php ENDPATH**/ ?>