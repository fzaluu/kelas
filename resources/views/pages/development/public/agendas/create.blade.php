@extends('layouts.dashboard')

@section('title', 'Buat Agenda Baru - XI PPLG 2')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Agenda Kegiatan</h1>
            <p class="text-xs text-slate-500">Jadwalkan kegiatan atau event baru untuk kelas XI PPLG 2.</p>
        </div>
        <a href="{{ route('development.public.agendas.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition">
            Kembali
        </a>
    </div>

    <form action="{{ route('development.public.agendas.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        @csrf

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Nama Agenda *</label>
            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Rapat Persiapan Classmeet" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
            @error('title') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Waktu Mulai *</label>
                <input type="datetime-local" name="start_at" required value="{{ old('start_at') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                @error('start_at') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Waktu Selesai (Opsional)</label>
                <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                @error('end_at') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Lokasi</label>
                <input type="text" name="location" value="{{ old('location') }}" placeholder="Contoh: Lab Komputer 2 / Ruang XI PPLG 2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Status *</label>
                <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLISHED" {{ old('status') === 'PUBLISHED' ? 'selected' : '' }}>PUBLISHED</option>
                    <option value="DRAFT" {{ old('status') === 'DRAFT' ? 'selected' : '' }}>DRAFT</option>
                    <option value="COMPLETED" {{ old('status') === 'COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                    <option value="CANCELLED" {{ old('status') === 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                </select>
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Deskripsi Agenda</label>
            <textarea name="description" rows="4" placeholder="Tulis rincian kegiatan..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">{{ old('description') }}</textarea>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-600/20">
                SIMPAN AGENDA
            </button>
        </div>
    </form>
</div>
@endsection