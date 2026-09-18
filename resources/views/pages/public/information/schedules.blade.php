@extends('layouts.public')

@section('title', 'Jadwal Pelajaran & Piket - XI PPLG 2')

@section('content')
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-slate-900">Jadwal Pelajaran & Piket Kebersihan</h1>
        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-xl">
            Informasi lengkap alokasi mata pelajaran harian dan daftar regu piket kebersihan kelas.
        </p>
    </div>
</section>

<div x-data="{ activeTab: 'lessons' }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <!-- Tab Switcher -->
    <div class="flex space-x-3 border-b border-slate-200 pb-4">
        <button @click="activeTab = 'lessons'" 
                :class="activeTab === 'lessons' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'"
                class="px-5 py-2.5 rounded-xl text-xs font-bold transition">
            Jadwal Pelajaran Mingguan
        </button>
        <button @click="activeTab = 'piket'" 
                :class="activeTab === 'piket' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'"
                class="px-5 py-2.5 rounded-xl text-xs font-bold transition">
            Jadwal Piket Kebersihan
        </button>
    </div>

    @php
        $days = ['SENIN' => 'Senin', 'SELASA' => 'Selasa', 'RABU' => 'Rabu', 'KAMIS' => 'Kamis', 'JUMAT' => 'Jumat'];
    @endphp

    <!-- TAB 1: JADWAL PELAJARAN -->
    <div x-show="activeTab === 'lessons'" class="grid grid-cols-1 md:grid-cols-5 gap-6">
        @foreach ($days as $enumDay => $indonesianDay)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="bg-slate-900 text-white py-3 px-4 text-center font-bold text-sm uppercase">
                        {{ $indonesianDay }}
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse ($schedules->get($enumDay, []) as $item)
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 space-y-1">
                                <span class="text-[10px] font-bold text-blue-600 font-mono block">{{ $item->start_time }} - {{ $item->end_time }}</span>
                                <h4 class="font-bold text-xs text-slate-900">{{ $item->subject_name }}</h4>
                                <p class="text-[10px] text-slate-500 truncate">{{ $item->teacher_name ?? 'Pengajar -' }} | {{ $item->room }}</p>
                            </div>
                        @empty
                            <div class="text-center py-6 text-[11px] text-slate-400 italic">
                                Tidak ada jadwal.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- TAB 2: JADWAL PIKET KEBERSIHAN -->
    <div x-show="activeTab === 'piket'" class="grid grid-cols-1 md:grid-cols-5 gap-6" x-cloak>
        @foreach ($days as $enumDay => $indonesianDay)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-blue-600 text-white py-3 px-4 text-center font-bold text-sm">
                    Piket {{ $indonesianDay }}
                </div>
                <div class="p-4">
                    <ul class="space-y-2 text-xs font-medium text-slate-700">
                        @forelse ($pikets->get($enumDay, []) as $index => $piketItem)
                            <li class="p-2 bg-slate-50 rounded-lg border border-slate-100 flex items-center space-x-2">
                                <span class="w-5 h-5 rounded bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold shrink-0">
                                    {{ $index + 1 }}
                                </span>
                                <span class="truncate font-bold text-slate-800">{{ $piketItem->student_name }}</span>
                            </li>
                        @empty
                            <li class="text-center py-6 text-[11px] text-slate-400 italic">
                                Belum ada regu piket.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection