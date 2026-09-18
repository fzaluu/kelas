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

<!-- 4. Anggota Kelas / Persetujuan Akun (Dinamis Toggle Menu) -->
@php
    $isApprovalRoute = request()->routeIs('development.approvals.*');
    $isMembersRoute  = request()->routeIs('development.members.*');
    $activeState     = $isApprovalRoute || $isMembersRoute;
    $pendingCount    = \App\Models\Core\User::where('approval_status', 'PENDING')->count();
@endphp

<a href="{{ $isApprovalRoute ? route('development.members.index') : route('development.approvals.index') }}" 
   class="flex items-center justify-between px-4 py-2.5 rounded-xl font-medium {{ $activeState ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition">
    <div class="flex items-center space-x-3">
        <span>{{ $isApprovalRoute ? '🛎️' : '👨‍🎓' }}</span>
        <span>{{ $isApprovalRoute ? 'Persetujuan Akun' : 'Anggota Kelas' }}</span>
    </div>

    <!-- Badge Jumlah Antrean Pending -->
    @if($pendingCount > 0)
        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $activeState ? 'bg-amber-400 text-slate-900' : 'bg-rose-500 text-white' }}">
            {{ $pendingCount }}
        </span>
    @endif
</a>

<div class="pt-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4">Konten & Media</div>

<!-- Konten Website (Prefix /dev/publik/announcements) -->
<a href="{{ route('development.public.announcements.index') }}" 
   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium {{ request()->routeIs('development.public.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition">
    <span>🌐</span>
    <span>Konten Website</span>
</a>

<!-- 6. Media & File (Slice 05 - Aktif) -->
<a href="{{ route('development.media.index') }}" 
   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium {{ request()->routeIs('development.media.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition">
    <span>📁</span>
    <span>Media & File</span>
</a>

<div class="pt-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider px-4">System & Audit</div>

<!-- 7. Activity Logs (Slice 06 - Aktif) -->
<a href="{{ route('development.activity-logs.index') }}" 
   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium {{ request()->routeIs('development.activity-logs.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition">
    <span>📋</span>
    <span>Activity Logs</span>
</a>

<!-- 8. Pengaturan Sistem -->
<a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition">
    <span>⚙️</span>
    <span>Pengaturan Sistem</span>
</a>