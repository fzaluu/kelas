@extends('layouts.dashboard')

@section('title', 'Jadwal Pelajaran & Piket - XI PPLG 2')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Jadwal Pelajaran & Piket</h1>
            <p class="text-xs text-slate-500">Kelola alokasi mata pelajaran harian dan regu piket kebersihan kelas XI PPLG 2.</p>
        </div>

        <div class="flex items-center space-x-2">
            <button onclick="toggleModal('modalSchedule', true)" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-sm">
                TAMBAH JADWAL
            </button>
            <button onclick="toggleModal('modalPiket', true)" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition shadow-sm">
                TAMBAH PIKET
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grid Hari (Senin - Jumat) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($days as $day)
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                        <h3 class="text-sm font-extrabold text-slate-900 tracking-wider uppercase">{{ $day }}</h3>
                        <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md border border-blue-200">
                            {{ isset($schedules[$day]) ? count($schedules[$day]) : 0 }} Mapel
                        </span>
                    </div>

                    <!-- List Mapel -->
                    <div class="space-y-2">
                        <p class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Jadwal Pelajaran</p>
                        @forelse($schedules[$day] ?? [] as $item)
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                                <div class="space-y-0.5 min-w-0 flex-1 pr-2">
                                    <p class="text-xs font-bold text-slate-800 truncate">{{ $item->subject_name }}</p>
                                    <p class="text-[10px] text-slate-500 truncate">{{ $item->teacher_name ?? 'Pengajar -' }} | {{ $item->room }}</p>
                                    <p class="text-[10px] font-mono font-bold text-blue-600">{{ $item->start_time }} - {{ $item->end_time }}</p>
                                </div>
                                <form action="{{ route('development.academic.schedules.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus mapel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[10px] font-bold text-rose-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-[11px] text-slate-400 italic">Belum ada jadwal mapel.</p>
                        @endforelse
                    </div>

                    <!-- List Piket -->
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <p class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Regu Piket Kelas</p>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse($pikets[$day] ?? [] as $p)
                                <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200/60">
                                    <span>{{ $p->student_name }}</span>
                                    <form action="{{ route('development.academic.piket.destroy', $p->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold ml-1">x</button>
                                    </form>
                                </span>
                            @empty
                                <p class="text-[11px] text-slate-400 italic">Belum ada petugas piket.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal Tambah Jadwal Pelajaran -->
<div id="modalSchedule" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full space-y-4 shadow-xl relative">
        <h3 class="text-sm font-extrabold text-slate-900">Tambah Jadwal Pelajaran</h3>
        <form action="{{ route('development.academic.schedules.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase">HARI *</label>
                <select name="day" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white">
                    @foreach($days as $d)
                        <option value="{{ $d }}">{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase">MATA PELAJARAN *</label>
                <input type="text" name="subject_name" required placeholder="Contoh: Pemrograman Web (Laravel)" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase">NAMA GURU / PENGAJAR</label>
                <input type="text" name="teacher_name" placeholder="Contoh: Pak Guru" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-[10px] font-bold text-slate-700 uppercase">JAM MULAI *</label>
                    <input type="time" name="start_time" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-700 uppercase">JAM SELESAI *</label>
                    <input type="time" name="end_time" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase">RUANGAN</label>
                <input type="text" name="room" value="Lab PPLG 2" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="toggleModal('modalSchedule', false)" class="px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Petugas Piket -->
<div id="modalPiket" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full space-y-4 shadow-xl relative">
        <h3 class="text-sm font-extrabold text-slate-900">Tambah Petugas Piket</h3>
        <form action="{{ route('development.academic.piket.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase">HARI *</label>
                <select name="day" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white">
                    @foreach($days as $d)
                        <option value="{{ $d }}">{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-700 uppercase">NAMA SISWA *</label>
                <input type="text" name="student_name" required placeholder="Masukkan nama siswa..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="toggleModal('modalPiket', false)" class="px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-4 py-1.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id, show) {
        const modal = document.getElementById(id);
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>
@endsection