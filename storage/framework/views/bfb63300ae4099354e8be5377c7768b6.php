<a href="<?php echo e(route('development.dashboard')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Dashboard Monitoring</span>
</a>

<div class="pt-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4">Core Platform</div>

<a href="<?php echo e(route('development.users.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.users.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>User & Akses</span>
</a>

<a href="<?php echo e(route('development.approvals.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.approvals.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Persetujuan Akun</span>
</a>

<a href="<?php echo e(route('development.roles.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.roles.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Role & Permission</span>
</a>

<a href="<?php echo e(route('development.members.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.members.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Anggota Kelas</span>
</a>

<div class="pt-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4">Akademik & Kelas</div>

<a href="<?php echo e(route('development.academic.schedules.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.academic.schedules.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Jadwal & Piket</span>
</a>

<a href="<?php echo e(route('development.academic.tasks.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.academic.tasks.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Tugas & Materi</span>
</a>

<div class="pt-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4">Konten & Media</div>

<!-- Pusat Kelola Seluruh Konten Website Publik -->
<a href="<?php echo e(route('development.public.announcements.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.public.*') && !request()->routeIs('development.public.messages.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Konten Website</span>
</a>

<a href="<?php echo e(route('development.public.messages.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.public.messages.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Pesan & Masukan</span>
</a>

<a href="<?php echo e(route('development.media.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.media.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Media & File</span>
</a>

<div class="pt-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4">System & Audit</div>

<a href="<?php echo e(route('development.activity-logs.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.activity-logs.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Activity Logs</span>
</a>

<a href="<?php echo e(route('development.system.settings.index')); ?>" 
   class="flex items-center px-4 py-2.5 rounded-xl font-medium <?php echo e(request()->routeIs('development.system.settings.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white'); ?> transition">
    <span>Pengaturan Sistem</span>
</a><?php /**PATH C:\laragon\www\website-pplg\resources\views/partials/sidebar-menu.blade.php ENDPATH**/ ?>