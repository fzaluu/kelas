@extends('layouts.dashboard')

@section('title', 'Kelola Dokumentasi - XI PPLG 2')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dokumentasi & Arsip File</h1>
            <p class="text-xs text-slate-500">Kelola berkas publikasi, dokumen penting, dan arsip kelas XI PPLG 2.</p>
        </div>

        <a href="{{ route('development.public.documents.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shrink-0">
            + Tambah Dokumen Baru 📄
        </a>
    </div>

    <!-- Tab Sub-Menu Konten Publik -->
    <div class="flex items-center space-x-2 border-b border-slate-200 overflow-x-auto pb-2">
        <a href="{{ route('development.public.announcements.index') }}" 
           class="px-4 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('development.public.announcements.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100' }}">
            📢 Pengumuman
        </a>
        
        <a href="{{ route('development.public.agendas.index') }}" 
           class="px-4 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('development.public.agendas.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100' }}">
            📅 Agenda
        </a>
        
        <a href="{{ route('development.public.documents.index') }}" 
           class="px-4 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('development.public.documents.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100' }}">
            📄 Dokumentasi
        </a>
        
        <a href="#" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">🖼️ Galeri Kegiatan</a>
        <a href="#" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">🚀 Karya Siswa</a>
        <a href="#" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">🏆 Prestasi</a>
        <a href="#" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">📚 Jadwal & Tugas</a>
    </div>

    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center space-x-2">
            <span>✅</span>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <th class="py-3 px-4">Nama Dokumen</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">File Terikat</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                @forelse($documents as $item)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 px-4 font-semibold text-slate-900">{{ $item->title }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">
                                {{ $item->category }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-mono text-[11px] text-blue-600">
                            📁 {{ $item->mediaFile->original_name ?? '-' }}
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->status === 'ACTIVE' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <form action="{{ route('development.public.documents.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] text-rose-600 font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">Belum ada dokumen yang diunggah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $documents->links() }}</div>
</div>
@endsection