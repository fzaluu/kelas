@extends('layouts.dashboard')

@section('title', 'Manajemen User & Akses')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Daftar Pengguna Sistem</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola akun pengguna dan keterikatannya dengan data anggota kelas.</p>
        </div>

        <a href="{{ route('development.users.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md">
            Tambah User Baru
        </a>
    </div>

    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Identitas / Member</th>
                        <th class="py-3.5 px-4">Username / Email</th>
                        <th class="py-3.5 px-4">Role / Akses</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-900">
                            <div>{{ $user->display_name }}</div>
                            @if($user->member)
                                <div class="text-[10px] text-blue-600 font-medium">Terhubung: {{ $user->member->schoolClass->name ?? 'Siswa' }}</div>
                            @else
                                <div class="text-[10px] text-slate-400 font-normal">Akun Non-Member</div>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <p class="font-medium text-slate-800">{{ $user->username }}</p>
                            <p class="text-[10px] text-slate-400">{{ $user->email ?? 'Tidak ada email' }}</p>
                        </td>
                        <td class="py-3.5 px-4">
                            @forelse($user->roles as $role)
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-blue-50 text-blue-700 uppercase border border-blue-200">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-[10px] text-slate-400 font-medium">Tanpa Role</span>
                            @endforelse
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold {{ $user->status === 'ACTIVE' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right flex items-center justify-end space-x-2">
                            <a href="{{ route('development.users.edit', $user->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 font-bold text-[10px] transition border border-slate-200">
                                Edit
                            </a>

                            @if($user->username !== 'dev')
                            <form action="{{ route('development.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[10px] transition border border-rose-200">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                            Belum ada data user terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection