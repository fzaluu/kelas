

<?php $__env->startSection('title', 'Buat Tugas Baru - XI PPLG 2'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Buat Tugas Baru</h1>
            <p class="text-xs text-slate-500">Berikan instruksi tugas atau materi baru untuk seluruh siswa XI PPLG 2.</p>
        </div>
        <a href="<?php echo e(route('development.academic.tasks.index')); ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition">
            Kembali
        </a>
    </div>

    <form action="<?php echo e(route('development.academic.tasks.store')); ?>" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        <?php echo csrf_field(); ?>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Judul Tugas *</label>
            <input type="text" name="title" required value="<?php echo e(old('title')); ?>" placeholder="Contoh: Membuat RESTful API dengan Laravel 13" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Mata Pelajaran *</label>
                <select name="subject_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="">-- Pilih Mapel --</option>
                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sub->id); ?>" <?php echo e(old('subject_id') == $sub->id ? 'selected' : ''); ?>>
                            <?php echo e($sub->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['subject_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Tenggat Waktu *</label>
                <input type="datetime-local" name="deadline" required value="<?php echo e(old('deadline')); ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                <?php $__errorArgs = ['deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Status *</label>
                <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLISHED" <?php echo e(old('status') === 'PUBLISHED' ? 'selected' : ''); ?>>PUBLISHED</option>
                    <option value="DRAFT" <?php echo e(old('status') === 'DRAFT' ? 'selected' : ''); ?>>DRAFT</option>
                    <option value="CLOSED" <?php echo e(old('status') === 'CLOSED' ? 'selected' : ''); ?>>CLOSED</option>
                    <option value="ARCHIVED" <?php echo e(old('status') === 'ARCHIVED' ? 'selected' : ''); ?>>ARCHIVED</option>
                </select>
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Deskripsi & Instruksi Tugas *</label>
            <textarea name="description" rows="5" required placeholder="Tuliskan petunjuk pengerjaan tugas di sini..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition"><?php echo e(old('description')); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-600/20">
                SIMPAN & TERBITKAN TUGAS
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/academic/tasks/create.blade.php ENDPATH**/ ?>