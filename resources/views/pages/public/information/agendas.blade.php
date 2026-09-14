@extends('layouts.public')

@section('title', 'Agenda & Kegiatan - XI PPLG 2')

@section('content')
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 uppercase tracking-wider inline-block mb-3">
            Jadwal Kegiatan
        </span>
        <h1 class="text-3xl font-extrabold text-slate-900">Agenda Kegiatan Kelas</h1>
        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-xl">
            Pantau jadwal event, rapat internal, ujian, dan kegiatan akademik mendatang.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Agenda Terdekat -->
    <div class="space-y-6">
        <h2 class="text-lg font-bold text-slate-900 flex items-center space-x-2">
            <span>🚀 Agenda Terdekat & Mendatang</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($upcomingAgendas as $agenda)
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-start space-x-5">
                    <div class="w-16 h-16 rounded-xl bg-blue-600 text-white flex flex-col items-center justify-center flex-shrink-0 font-bold">
                        <span class="text-lg leading-none">{{ \Carbon\Carbon::parse($agenda->start_at)->format('d') }}</span>
                        <span class="text-[10px] uppercase tracking-wider mt-1">{{ \Carbon\Carbon::parse($agenda->start_at)->format('M Y') }}</span>
                    </div>
                    <div class="space-y-1.5 flex-grow">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 uppercase">{{ $agenda->category ?? 'KEGIATAN' }}</span>
                        <h3 class="text-base font-bold text-slate-900">{{ $agenda->title }}</h3>
                        <p class="text-xs text-slate-500">📍 {{ $agenda->location ?? 'Ruang Kelas XI PPLG 2' }}</p>
                        <p class="text-xs font-semibold text-blue-600">
                            🕐 {{ \Carbon\Carbon::parse($agenda->start_at)->format('H:i') }} - {{ \Carbon\Carbon::parse($agenda->end_at)->format('H:i WIB') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-10 bg-white rounded-2xl border border-dashed border-slate-200">
                    <p class="text-xs text-slate-400">Tidak ada agenda kegiatan terdekat saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Riwayat Agenda -->
    @if ($pastAgendas->isNotEmpty())
        <div class="space-y-4 pt-6 border-t border-slate-200">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Riwayat Kegiatan Selesai</h3>
            <div class="space-y-3">
                @foreach ($pastAgendas as $past)
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex justify-between items-center text-xs">
                        <div>
                            <span class="font-bold text-slate-800">{{ $past->title }}</span>
                            <span class="text-slate-400 mx-2">•</span>
                            <span class="text-slate-500">📍 {{ $past->location ?? 'Lab Komputer' }}</span>
                        </div>
                        <span class="text-slate-400 font-medium">{{ \Carbon\Carbon::parse($past->start_at)->format('d M Y') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection