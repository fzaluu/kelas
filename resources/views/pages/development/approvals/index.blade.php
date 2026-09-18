@extends('layouts.dashboard')

@section('title', 'Persetujuan Pendaftaran')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Header dengan Tombol Kembali -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('development.members.index') }}" 
           class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition shadow-sm shrink-0" 
           title="Kembali ke Anggota Kelas">
            ⬅️
        </a>
        <div class="min-w-0">
            <h1 class="text-xl font-bold text-slate-900 truncate">Persetujuan Akun Anggota (Approval Queue)</h1>
            <p class="text-xs text-slate-500">Daftar calon anggota yang melakukan pendaftaran mandiri dan menunggu verifikasi Developer.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Calon Siswa</th>
                        <th class="py-3.5 px-4">NIS</th>
                        <th class="py-3.5 px-4">Username / Email</th>
                        <th class="py-3.5 px-4">Waktu Daftar</th>
                        <th class="py-3.5 px-4 text-center">Aksi Persetujuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingUsers as $user)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-900">
                            {{ $user->name }}
                        </td>
                        <td class="py-3.5 px-4 font-mono">
                            {{ $user->classMember->nis ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4">
                            <p class="font-bold text-slate-800">@ {{ $user->username }}</p>
                            <p class="text-[10px] text-slate-400">{{ $user->email }}</p>
                        </td>
                        <td class="py-3.5 px-4 text-[10px] text-slate-500">
                            {{ $user->created_at->diffForHumans() }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <form action="{{ route('development.approvals.approve', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] transition shadow-sm">
                                        ✓ Setujui (Approve)
                                    </button>
                                </form>
                                <form action="{{ route('development.approvals.reject', $user->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran akun ini?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[10px] transition border border-rose-200">
                                        ✕ Tolak (Reject)
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                            🎉 Tidak ada pendaftaran pending. Semua akun telah ditinjau!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection