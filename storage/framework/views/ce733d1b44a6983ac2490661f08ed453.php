

<?php $__env->startSection('title', 'Tentang & Profil Resmi - XI PPLG 2'); ?>

<?php $__env->startSection('content'); ?>

<!-- HEADER HALAMAN -->
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-12 sm:py-16 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 uppercase tracking-wider inline-block mb-3">
            Profil Resmi Kelas
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Mengenal XI PPLG 2 Lebih Dekat
        </h1>
        <p class="mt-2 text-sm sm:text-base text-slate-600 max-w-2xl">
            Informasi identitas, struktur organisasi, serta keanggotaan siswa Rekayasa Perangkat Lunak & Gim SMKN 4 Kota Tasikmalaya.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">

    <!-- 📖 1. PROFIL KELAS -->
    <section class="space-y-8">
        
        <!-- Identitas Kelas Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kelas</span>
                <span class="text-base font-extrabold text-slate-900">XI PPLG 2</span>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jurusan</span>
                <span class="text-base font-extrabold text-blue-600">PPLG</span>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Sekolah</span>
                <span class="text-base font-extrabold text-slate-900 truncate block" title="SMKN 4 Tasikmalaya">SMKN 4 TSM</span>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tahun Ajaran</span>
                <span class="text-base font-extrabold text-slate-900">2024/2026</span>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Siswa Aktif</span>
                <span class="text-base font-extrabold text-blue-600"><?php echo e($members->count()); ?> Orang</span>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Wali Kelas</span>
                <span class="text-xs font-bold text-slate-800 truncate block mt-1">Wali PPLG 2</span>
            </div>
        </div>

        <!-- Deskripsi Singkat & Motto -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-4">
            <h2 class="text-xl font-bold text-slate-900">Tentang XI PPLG 2</h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                <?php echo e($profile->description ?? 'Kami adalah komunitas pembelajar di kelas XI PPLG 2 SMKN 4 Kota Tasikmalaya. Berfokus pada penguasaan alur rekayasa perangkat lunak, pemrograman web modern, aplikasi mobile, basis data, serta pengembangan gim berstandar industri.'); ?>

            </p>

            <?php if(!empty($profile->motto)): ?>
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-100 text-xs sm:text-sm text-blue-900 font-medium italic">
                    💡 Motto: "<?php echo e($profile->motto); ?>"
                </div>
            <?php endif; ?>
        </div>

        <!-- Nilai Kebersamaan -->
        <div>
            <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4">Nilai Utama Kebersamaan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-2">
                    <div class="text-2xl">💡</div>
                    <h4 class="font-bold text-slate-900 text-sm">Kreatif</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Selalu mencari ide dan pendekatan baru dalam memecahkan masalah pemrograman.</p>
                </div>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-2">
                    <div class="text-2xl">🤝</div>
                    <h4 class="font-bold text-slate-900 text-sm">Kolaboratif</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Mengutamakan kerja tim, transparansi, dan saling mendukung dalam project kelas.</p>
                </div>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-2">
                    <div class="text-2xl">🚀</div>
                    <h4 class="font-bold text-slate-900 text-sm">Adaptif</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Cepat menyesuaikan diri dengan perkembangan teknologi perangkat lunak terkini.</p>
                </div>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-2">
                    <div class="text-2xl">💻</div>
                    <h4 class="font-bold text-slate-900 text-sm">Teknologi</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Memanfaatkan ekosistem digital secara maksimal untuk efisiensi operasional kelas.</p>
                </div>
            </div>
        </div>

        <!-- Visi & Misi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-slate-900 text-white rounded-3xl p-8 space-y-3">
                <span class="text-xs font-bold text-blue-400 uppercase tracking-wider">Cita-Cita Bersama</span>
                <h3 class="text-xl font-bold">Visi Kelas</h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    <?php echo e($profile->vision ?? '"Menjadi kelas unggulan yang melahirkan talenta pengembang perangkat lunak berintegritas, disiplin, berdaya saing tinggi, serta bertakwa."'); ?>

                </p>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-200 space-y-3">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Langkah Strategis</span>
                <h3 class="text-xl font-bold text-slate-900">Misi Kelas</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    <?php echo e($profile->mission ?? 'Memelihara budaya belajar berkesinambungan, membangun sistem manajemen kelas yang transparan secara digital, serta menjaga kekompakan antar siswa.'); ?>

                </p>
            </div>
        </div>

    </section>

    <hr class="border-slate-200 my-12">

    <!-- 🏫 2. STRUKTUR ORGANISASI KELAS -->
    <section id="structure" class="space-y-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Struktur Pengelolaan Kelas</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Mengenal wali kelas dan pengurus yang mengelola aktivitas harian kelas.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $titleName = $pos->title ?? $pos->position_name ?? 'Pengurus Kelas';
                    $memberName = optional($pos->member)->name ?? 'Belum Ditentukan';
                ?>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center shadow-sm space-y-3 hover:border-blue-300 transition">
                    <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-700 font-extrabold flex items-center justify-center mx-auto text-base uppercase">
                        <?php echo e(substr($memberName, 0, 2)); ?>

                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block"><?php echo e($titleName); ?></span>
                        <h4 class="font-bold text-sm text-slate-900 truncate mt-1" title="<?php echo e($memberName); ?>">
                            <?php echo e($memberName); ?>

                        </h4>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <!-- Fallback Pengurus Default bila DB Belum Diisi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center shadow-sm space-y-3">
                    <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-700 font-extrabold flex items-center justify-center mx-auto text-base uppercase">WK</div>
                    <div>
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block">Wali Kelas</span>
                        <h4 class="font-bold text-sm text-slate-900">Wali PPLG 2</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center shadow-sm space-y-3">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-700 font-extrabold flex items-center justify-center mx-auto text-base uppercase">KM</div>
                    <div>
                        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider block">Ketua Kelas</span>
                        <h4 class="font-bold text-sm text-slate-900">Ketua XI PPLG 2</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center shadow-sm space-y-3">
                    <div class="w-16 h-16 rounded-full bg-purple-100 text-purple-700 font-extrabold flex items-center justify-center mx-auto text-base uppercase">SK</div>
                    <div>
                        <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wider block">Sekretaris</span>
                        <h4 class="font-bold text-sm text-slate-900">Sekretaris Kelas</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center shadow-sm space-y-3">
                    <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-700 font-extrabold flex items-center justify-center mx-auto text-base uppercase">BD</div>
                    <div>
                        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider block">Bendahara</span>
                        <h4 class="font-bold text-sm text-slate-900">Bendahara Kelas</h4>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <hr class="border-slate-200 my-12">

    <!-- 👥 3. DAFTAR ANGGOTA KELAS -->
    <section id="members" class="space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Anggota XI PPLG 2</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar siswa aktif yang menjadi bagian dari rombongan belajar.</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-slate-100 text-xs font-bold text-slate-600 self-start sm:self-auto">
                Total: <?php echo e($members->count()); ?> Siswa Aktif
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-center hover:bg-white hover:shadow-md transition group">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 font-bold flex items-center justify-center mx-auto mb-3 text-xs uppercase group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <?php echo e(substr($member->name, 0, 2)); ?>

                    </div>
                    <h4 class="font-bold text-xs text-slate-900 truncate" title="<?php echo e($member->name); ?>"><?php echo e($member->name); ?></h4>
                    <p class="text-[10px] text-slate-400 mt-0.5">Absen #<?php echo e($index + 1); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-6 text-center py-8 text-xs text-slate-400 border border-dashed border-slate-200 rounded-2xl">
                    Belum ada data anggota siswa aktif di database. Tambahkan melalui menu Anggota Kelas di Dashboard Development.
                </div>
            <?php endif; ?>
        </div>
    </section>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\website-pplg\resources\views/pages/public/about.blade.php ENDPATH**/ ?>