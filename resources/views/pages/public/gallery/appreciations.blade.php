@extends('layouts.public')

@section('title', 'Prestasi & Apresiasi - XI PPLG 2')

@section('content')
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 uppercase tracking-wider inline-block mb-3">
            Pencapaian
        </span>
        <h1 class="text-3xl font-extrabold text-slate-900">Prestasi & Apresiasi Siswa</h1>
        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-xl">
            Rekam jejak penghargaan, juara kompetisi teknologi, dan apresiasi keikutsertaan event akademik/non-akademik.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse ($appreciations as $app)
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm flex items-start space-x-5 hover:border-amber-300 transition">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center font-extrabold text-2xl flex-shrink-0 shadow-sm">
                    🏆
                </div>
                <div class="space-y-2 flex-grow">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded uppercase">
                            {{ $app->level ?? 'TINGKAT KOTA/PROVINSI' }}
                        </span>
                        <span class="text-[11px] text-slate-400">
                            {{ \Carbon\Carbon::parse($app->achievement_date)->format('M Y') }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 leading-tight">{{ $app->title }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $app->description }}</p>

                    <!-- Penerima Penghargaan -->
                    @if($app->members->isNotEmpty())
                        <div class="pt-3 border-t border-slate-100 mt-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Penerima Apresiasi:</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($app->members as $am)
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-[11px] font-semibold text-slate-700">
                                        {{ $am->member->name ?? 'Siswa' }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-400">Belum ada rekam prestasi publik yang dicatat.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection