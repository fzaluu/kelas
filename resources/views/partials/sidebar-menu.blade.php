<!-- 1. Dashboard Monitoring -->
<a href="{{ route('development.dashboard') }}" 
   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium {{ request()->routeIs('development.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition">
    <span>🏠</span>
    <span>Dashboard Monitoring</span>
</a>

<div class="pt-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4">Core Platform</div>

<!-- 2. User & Akses -->
<a href="{{ route('development.users.index') }}" 
   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium {{ request()->routeIs('development.users.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition">
    <span>👥</span>
    <span>User & Akses</span>
</a>

<!-- 3. Role & Permission (Slice 03) -->
<a href="{{ route('development.roles.index') }}" 
   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium {{ request()->routeIs('development.roles.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition">
    <span>🔐</span>
    <span>Role & Permission</span>
</a>

<!-- 4. Anggota Kelas (Slice 04 - Active Dynamic Route) -->
<a href="{{ route('development.members.index') }}" 
   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium {{ request()->routeIs('development.members.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition">
    <span>👨‍🎓</span>
    <span>Anggota Kelas</span>
</a>

<div class="pt-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4">Konten & Media</div>

<!-- 5. Konten Website -->
<a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition">
    <span>🌐</span>
    <span>Konten Website</span>
</a>

<!-- 6. Media & File -->
<a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition">
    <span>📁</span>
    <span>Media & File</span>
</a>

<div class="pt-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4">System & Audit</div>

<!-- 7. Activity Logs -->
<a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition">
    <span>📋</span>
    <span>Activity Logs</span>
</a>

<!-- 8. Pengaturan Sistem -->
<a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition">
    <span>⚙️</span>
    <span>Pengaturan Sistem</span>
</a>