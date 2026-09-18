@extends('layouts.dashboard')

@section('title', 'Kelola Pengumuman - XI PPLG 2')

@section('content')
<div class="space-y-6">
    <!-- Header & Navigation Bar Konten Publik -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Konten Publik Portal</h1>
            <p class="text-xs text-slate-500">Kelola pengumuman, agenda, galeri, hingga dokumen XI PPLG 2.</p>
        </div>

        <a href="{{ route('development.public.announcements.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shrink-0 self-start sm:self-auto">
            BUAT PENGUMUMAN BARU
        </a>
    </div>

    <!-- Tab Sub-Menu Konten Publik -->
    <div class="flex items-center space-x-2 border-b border-slate-200 overflow-x-auto pb-2">
        <a href="{{ route('development.public.announcements.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-blue-600 text-white shadow-sm">Pengumuman</a>
        <a href="{{ route('development.public.agendas.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition">Agenda</a>
        <a href="{{ route('development.public.documents.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition">Dokumentasi</a>
        <a href="{{ route('development.public.galleries.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition">Galeri Kegiatan</a>
    </div>

    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table Pengumuman -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <th class="py-3 px-4">Judul</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Prioritas</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                @forelse($announcements as $item)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 px-4 font-semibold text-slate-900">{{ $item->title }}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">{{ $item->category }}</span></td>
                        <td class="py-3 px-4">
                            @if($item->priority === 'URGENT')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">URGENT</span>
                            @elseif($item->priority === 'IMPORTANT')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">IMPORTANT</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">NORMAL</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->status === 'PUBLISHED' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">{{ $item->status }}</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <form action="{{ route('development.public.announcements.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] text-rose-600 font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">Belum ada pengumuman yang dibuat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $announcements->links() }}</div>
</div>
@endsection