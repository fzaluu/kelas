@extends('layouts.dashboard')

@section('title', 'Persetujuan Akun - Admin')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Antrean Persetujuan Akun</h1>
        <p class="text-xs text-slate-500">Tinjau dan setujui pendaftaran akun siswa baru.</p>
    </div>

    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                <tr>
                    <th class="p-4">Username</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Tanggal Daftar</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pendingUsers as $u)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-4 font-bold text-slate-900">{{ $u->username }}</td>
                        <td class="p-4">{{ $u->email }}</td>
                        <td class="p-4">{{ $u->created_at->format('d M Y, H:i') }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                PENDING
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <form action="{{ route('development.approvals.approve', $u->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-emerald-600 text-white rounded-lg font-bold text-[10px] hover:bg-emerald-700">Setujui</button>
                            </form>
                            <form action="{{ route('development.approvals.reject', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pendaftaran ini?')">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-rose-600 text-white rounded-lg font-bold text-[10px] hover:bg-rose-700">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">Tidak ada antrean pendaftaran yang perlu disetujui.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $pendingUsers->links() }}</div>
</div>
@endsection