@extends('layouts.public')

@section('title', 'Karya & Project Showcase - XI PPLG 2')

@section('content')
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider inline-block mb-3">
            Portfolio Siswa
        </span>
        <h1 class="text-3xl font-extrabold text-slate-900">Karya & Project Showcase</h1>
        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-xl">
            Hasil karya rekayasa perangkat lunak, aplikasi web, mobile, dan pengembangan gim buatan siswa XI PPLG 2.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse ($projects as $project)
            @php
                $firstMedia = $project->projectMedia->first()?->mediaFile;
            @endphp
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col justify-between space-y-6 hover:border-blue-300 transition">
                <div class="space-y-4">
                    <div class="flex justify-between items-start">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase">
                            Karya Siswa
                        </span>
                    </div>

                    @if($firstMedia)
                        <div class="h-44 rounded-2xl overflow-hidden bg-slate-100 border border-slate-100">
                            <img src="{{ $firstMedia->url }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <h3 class="text-xl font-bold text-slate-900 leading-tight">{{ $project->title }}</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        {{ $project->description }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 space-y-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tim Pengembang:</span>
                    <div class="flex flex-wrap gap-2">
                        @forelse($project->members as $pm)
                            <span class="text-xs text-slate-700 font-bold bg-slate-50 px-3 py-1 rounded-lg border border-slate-200">
                                👤 {{ $pm->member->name ?? 'Siswa XI PPLG 2' }}
                            </span>
                        @empty
                            <span class="text-xs text-slate-700 font-bold bg-slate-50 px-3 py-1 rounded-lg border border-slate-200">
                                👤 Siswa XI PPLG 2
                            </span>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-400">Belum ada karya project siswa yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection