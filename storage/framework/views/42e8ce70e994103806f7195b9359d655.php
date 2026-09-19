

<?php $__env->startSection('title', 'Tambah Prestasi Siswa - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Catat Prestasi & Apresiasi</h1>
            <p class="text-xs text-slate-500">Catat juara perlombaan atau penghargaan yang diraih siswa XI PPLG 2.</p>
        </div>
        <a href="<?php echo e(route('development.content.appreciations.index')); ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition">← Kembali</a>
    </div>

    <form action="<?php echo e(route('development.content.appreciations.store')); ?>" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        <?php echo csrf_field(); ?>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Judul Penghargaan / Prestasi *</label>
            <input type="text" name="title" required value="<?php echo e(old('title')); ?>" placeholder="Contoh: Juara 1 Web Design Tingkat Kota" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 transition">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kategori *</label>
                <input type="text" name="category" required value="COMPETITION" placeholder="Contoh: COMPETITION / ACADEMIC" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 transition">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Perolehan *</label>
                <input type="date" name="achievement_date" required value="<?php echo e(date('Y-m-d')); ?>" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 transition">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Status *</label>
                <select name="status" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLISHED">Diterbitkan</option>
                    <option value="DRAFT">Draf (Konsep)</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Akses *</label>
                <select name="visibility" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLIC">Publik (Semua Orang)</option>
                    <option value="MEMBER">Khusus Anggota Kelas</option>
                </select>
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Pilih Foto Sertifikat / Piala *</label>
            <select name="media_file_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                <option value="">-- Pilih Berkas Gambar --</option>
                <?php $__currentLoopData = $imageFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($media->id); ?>"><?php echo e($media->original_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Siswa Berprestasi</label>
            <select name="member_ids[]" multiple class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition h-28">
                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($m->id); ?>"><?php echo e($m->name); ?> (<?php echo e($m->nis); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi Prestasi</label>
            <textarea name="description" rows="3" placeholder="Tuliskan keterangan detail mengenai kejuaraan/prestasi ini..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 transition"><?php echo e(old('description')); ?></textarea>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-amber-600/20">
                SIMPAN PRESTASI
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/public/content/appreciations/create.blade.php ENDPATH**/ ?>