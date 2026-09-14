@extends('layouts.public')

@section('title', 'Pengumuman Resmi - XI PPLG 2')

@section('content')
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 uppercase tracking-wider inline-block mb-3">
            Informasi Publik
        </span>
        <h1 class="text-3xl font-extrabold text-slate-900">Pengumuman Resmi Kelas</h1>
        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-xl">
            Tetap terhubung dengan informasi dan pemberitahuan harian terbaru dari sekolah & pengurus kelas.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($announcements as $ann)
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:border-blue-300 transition flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 uppercase tracking-wider">
                            {{ $ann->priority ?? 'INFO' }}
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium">
                            {{ \Carbon\Carbon::parse($ann->published_at)->format('d M Y') }}
                        </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 leading-snug">{{ $ann->title }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                        {{ Str::limit(strip_tags($ann->content), 120) }}
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 text-[11px] font-semibold text-blue-600">
                    Oleh: {{ $ann->author->name ?? 'Pengurus Kelas' }}
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-400">Belum ada pengumuman publik yang diterbitkan.</p>
            </div>
        @endforelse
    </div>

    @if ($announcements->hasPages())
        <div class="mt-8">
            {{ $announcements->links() }}
        </div>
    @endif
</div>
@endsection