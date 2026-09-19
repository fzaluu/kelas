

<?php $__env->startSection('title', 'Tambah Anggota Kelas'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center space-x-3">
        <a href="<?php echo e(route('development.members.index')); ?>" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
            Kembali
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Anggota Kelas Baru</h1>
            <p class="text-xs text-slate-500">Masukkan data identitas resmi siswa ke dalam database kelas.</p>
        </div>
    </div>

    <form action="<?php echo e(route('development.members.store')); ?>" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="class_id" value="<?php echo e($classes->first()->id ?? 1); ?>">

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa *</label>
            <input type="text" name="name" value="<?php echo e(old('name')); ?>" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-600 text-[10px]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">NIS (Internal)</label>
                <input type="text" name="nis" value="<?php echo e(old('nis')); ?>" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500">
                <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-600 text-[10px]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">NISN (Internal)</label>
                <input type="text" name="nisn" value="<?php echo e(old('nisn')); ?>" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500">
                <?php $__errorArgs = ['nisn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-600 text-[10px]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin *</label>
                <select name="gender" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="L" <?php echo e(old('gender') === 'L' ? 'selected' : ''); ?>>Laki-laki (L)</option>
                    <option value="P" <?php echo e(old('gender') === 'P' ? 'selected' : ''); ?>>Perempuan (P)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Status Keanggotaan *</label>
                <select name="member_status" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="ACTIVE" selected>ACTIVE</option>
                    <option value="INACTIVE">INACTIVE</option>
                    <option value="GRADUATED">GRADUATED</option>
                    <option value="TRANSFERRED">TRANSFERRED</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Bio Publik (Opsional)</label>
            <textarea name="public_bio" rows="2" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500"><?php echo e(old('public_bio')); ?></textarea>
        </div>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="<?php echo e(route('development.members.index')); ?>" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold">Simpan Anggota</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/members/create.blade.php ENDPATH**/ ?>