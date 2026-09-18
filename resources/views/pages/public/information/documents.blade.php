@extends('layouts.public')

@section('title', 'Dokumentasi & Arsip - XI PPLG 2')

@section('content')
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 uppercase tracking-wider inline-block mb-3">
            Arsip Digital
        </span>
        <h1 class="text-3xl font-extrabold text-slate-900">Dokumentasi & Berkas Kelas</h1>
        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-xl">
            Unduh modul pembelajaran, berkas administrasi, dan dokumen resmi kelas XI PPLG 2.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($documents as $doc)
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-700 uppercase tracking-wider">
                            {{ $doc->category }}
                        </span>
                        <span class="text-[11px] text-slate-400 font-mono">
                            {{ number_format(($doc->mediaFile->file_size ?? 0) / 1024, 1) }} KB
                        </span>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 leading-snug">{{ $doc->title }}</h3>
                    
                    @if($doc->description)
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $doc->description }}</p>
                    @endif
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 text-[11px]">
                        📅 {{ $doc->created_at ? $doc->created_at->format('d M Y') : '-' }}
                    </span>

                    @if($doc->mediaFile)
                        <a href="{{ $doc->mediaFile->url }}" target="_blank" download class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center space-x-1">
                            <span>Unduh File</span>
                            <span>📥</span>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-400">Belum ada dokumen publikasi yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $documents->links() }}</div>
</div>
@endsection