

<?php $__env->startSection('title', 'Edit User'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center space-x-3">
        <a href="<?php echo e(route('development.users.index')); ?>" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
            Kembali
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900">Edit Akun Pengguna</h1>
            <p class="text-xs text-slate-500">Ubah kredensial atau keterikatan pengguna <span class="font-bold text-slate-700"><?php echo e($user->username); ?></span>.</p>
        </div>
    </div>

    <form action="<?php echo e(route('development.users.update', $user->id)); ?>" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Hubungkan Anggota Kelas -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Anggota Kelas (Siswa)</label>
            <select name="member_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white">
                <option value="">-- Non-Member (Akun Developer / Wali Kelas) --</option>
                <?php $__currentLoopData = $unlinkedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($member->id); ?>" <?php echo e(old('member_id', $user->member_id) == $member->id ? 'selected' : ''); ?>>
                        <?php echo e($member->name); ?> (NIS: <?php echo e($member->nis ?? '-'); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['member_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Username -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Username <span class="text-rose-500">*</span></label>
            <input type="text" name="username" value="<?php echo e(old('username', $user->username)); ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" required>
            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Email -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Email (Opsional)</label>
            <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" placeholder="budi@smkn4tasikmalaya.sch.id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Role / Hak Akses -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Role / Hak Akses <span class="text-rose-500">*</span></label>
            <select name="role_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white" required>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->id); ?>" <?php echo e($user->roles->contains($role->id) ? 'selected' : ''); ?>>
                        <?php echo e(strtoupper($role->name)); ?> <?php if($role->description): ?> - (<?php echo e($role->description); ?>) <?php endif; ?>
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['role_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Status -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Status Akun <span class="text-rose-500">*</span></label>
            <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white" required>
                <option value="ACTIVE" <?php echo e(old('status', $user->status) === 'ACTIVE' ? 'selected' : ''); ?>>ACTIVE</option>
                <option value="INACTIVE" <?php echo e(old('status', $user->status) === 'INACTIVE' ? 'selected' : ''); ?>>INACTIVE</option>
                <option value="SUSPENDED" <?php echo e(old('status', $user->status) === 'SUSPENDED' ? 'selected' : ''); ?>>SUSPENDED</option>
            </select>
            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Password Baru (Opsional) -->
        <div class="space-y-1">
            <div class="flex items-center justify-between">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Password Baru</label>
                <span class="text-[10px] text-slate-400 italic">Kosongkan jika tidak ingin mengubah password</span>
            </div>
            <input type="password" 
                   name="password" 
                   placeholder="Masukkan password baru (Opsional)" 
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] text-rose-500 font-semibold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Submit Button -->
        <div class="pt-4 flex justify-end space-x-3">
            <a href="<?php echo e(route('development.users.index')); ?>" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-md">
                Update User
            </button>
        </div>

    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/development/users/edit.blade.php ENDPATH**/ ?>