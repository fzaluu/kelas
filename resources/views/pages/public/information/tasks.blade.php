@extends('layouts.public')

@section('title', 'Tugas & Deadline - XI PPLG 2')

@section('content')
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 uppercase tracking-wider inline-block mb-3">
            Akademik
        </span>
        <h1 class="text-3xl font-extrabold text-slate-900">Daftar Tugas & Batas Pengumpulan</h1>
        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-xl">
            Pantau tugas aktif dan tenggat waktu pengumpulan agar pengerjaan tetap tepat waktu.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($activeTasks as $task)
            @php
                $taskDeadline = $task->deadline ?? $task->due_at;
            @endphp
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">
                            {{ $task->subject->name ?? 'Mata Pelajaran' }}
                        </span>
                        @if($taskDeadline)
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                ⏱️ {{ \Carbon\Carbon::parse($taskDeadline)->diffForHumans() }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-base font-bold text-slate-900 leading-snug">{{ $task->title }}</h3>
                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                        {{ Str::limit(strip_tags($task->description), 100) }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 space-y-3">
                    <!-- Tanggal Deadline (WIB) -->
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-medium">Batas Waktu:</span>
                        <span class="font-bold text-slate-800">
                            {{ $taskDeadline ? \Carbon\Carbon::parse($taskDeadline)->format('d M Y, H:i') . ' WIB' : '-' }}
                        </span>
                    </div>

                    <!-- Jumlah Siswa Yang Sudah Mengumpulkan -->
                    <div class="flex justify-between items-center text-xs ">
                        <span class="text-slate-400 font-medium">Pengumpulan:</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                            {{ $task->submissions_count ?? 0 }} Siswa
                        </span>
                    </div>

                    <!-- CTA Submit -->
                    <a href="{{ route('login') }}" class="block text-center w-full py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-xl font-bold text-xs transition mt-2">
                        Kumpulkan Tugas Via Portal Siswa →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-400">Belum ada tugas aktif yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection