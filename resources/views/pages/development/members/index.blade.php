@extends('layouts.dashboard')

@section('title', 'Manajemen Anggota Kelas')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Daftar Anggota Kelas</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola biodata siswa, NIS, NISN, dan tautan akun pengguna.</p>
        </div>

        <a href="{{ route('development.members.create') }}" class="inline-flex items-center justify-center space-x-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-600/20">
            <span>➕</span>
            <span>Tambah Siswa Baru</span>
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
        <form action="{{ route('development.members.index') }}" method="GET" class="w-full sm:w-72">
            <div class="relative">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari nama, NIS, atau NISN..." 
                       class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
            </div>
        </form>
    </div>

    <!-- Table Card Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Siswa</th>
                        <th class="py-3.5 px-4">NIS / NISN</th>
                        <th class="py-3.5 px-4">Gender</th>
                        <th class="py-3.5 px-4">Akun Terhubung</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $member)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-900 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full {{ $member->gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }} font-bold flex items-center justify-center text-xs uppercase shrink-0">
                                {{ substr($member->full_name, 0, 2) }}
                            </div>
                            <span>{{ $member->full_name }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <p class="font-medium text-slate-800">{{ $member->nis }}</p>
                            <p class="text-[10px] text-slate-400">NISN: {{ $member->nisn ?? '-' }}</p>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $member->gender === 'L' ? 'bg-blue-50 text-blue-600 border border-blue-200' : 'bg-pink-50 text-pink-600 border border-pink-200' }}">
                                {{ $member->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($member->user)
                                <span class="text-xs font-semibold text-slate-700">@ {{ $member->user->username }}</span>
                            @else
                                <span class="text-[10px] text-slate-400 italic">Belum dihubungkan</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>{{ $member->status }}</span>
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right flex items-center justify-end space-x-2">
                            <a href="{{ route('development.members.edit', $member->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 font-bold text-[10px] transition border border-slate-200">
                                Edit
                            </a>
                            <form action="{{ route('development.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[10px] transition border border-rose-200">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                            Belum ada data siswa terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $members->links() }}
        </div>
        @endif
    </div>

</div>
@endsection