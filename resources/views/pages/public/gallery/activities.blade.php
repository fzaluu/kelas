@extends('layouts.public')

@section('title', 'Dokumentasi & Kegiatan - XI PPLG 2')

@section('content')
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 uppercase tracking-wider inline-block mb-3">
            Dokumentasi Kelas
        </span>
        <h1 class="text-3xl font-extrabold text-slate-900">Album Kegiatan XI PPLG 2</h1>
        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-xl">
            Kumpulan momen kebersamaan, riset lab komputer, ekstrakurikuler, dan dokumentasi aktivitas siswa.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($galleries as $item)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition group">
                <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                    @if(optional($item->mediaFile)->file_path)
                        <img src="{{ asset('storage/' . $item->mediaFile->file_path) }}" 
                             alt="{{ $item->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="text-center text-slate-400">
                            <span class="text-3xl block mb-1">📷</span>
                            <span class="text-[11px] font-medium">Tidak ada foto</span>
                        </div>
                    @endif
                    <span class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-md text-white px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                        {{ $item->category ?? 'ACTIVITY' }}
                    </span>
                </div>
                
                <div class="p-5 space-y-2">
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block">
                        {{ $item->category ?? 'DOKUMENTASI' }}
                    </span>
                    <h3 class="font-bold text-slate-900 text-base group-hover:text-blue-600 transition truncate">
                        {{ $item->title }}
                    </h3>
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                        {{ $item->description ?? 'Dokumentasi resmi kegiatan siswa XI PPLG 2.' }}
                    </p>
                    <div class="pt-3 border-t border-slate-100 flex justify-between items-center text-[11px] text-slate-400">
                        <span>{{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d M Y') : '-' }}</span>
                        <span class="font-bold text-blue-600">Terbit</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-400">Belum ada foto kegiatan yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>

    @if (method_exists($galleries, 'hasPages') && $galleries->hasPages())
        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection