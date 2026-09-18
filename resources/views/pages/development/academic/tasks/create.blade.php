@extends('layouts.dashboard')

@section('title', 'Buat Tugas Baru - XI PPLG 2')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Buat Tugas Baru</h1>
            <p class="text-xs text-slate-500">Berikan instruksi tugas atau materi baru untuk seluruh siswa XI PPLG 2.</p>
        </div>
        <a href="{{ route('development.academic.tasks.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition">
            Kembali
        </a>
    </div>

    <form action="{{ route('development.academic.tasks.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        @csrf

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Judul Tugas *</label>
            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Membuat RESTful API dengan Laravel 13" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
            @error('title') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Mata Pelajaran *</label>
                <select name="subject_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}" {{ old('subject_id') == $sub->id ? 'selected' : '' }}>
                            {{ $sub->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_id') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Tenggat Waktu *</label>
                <input type="datetime-local" name="deadline" required value="{{ old('deadline') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                @error('deadline') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Status *</label>
                <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLISHED" {{ old('status') === 'PUBLISHED' ? 'selected' : '' }}>PUBLISHED</option>
                    <option value="DRAFT" {{ old('status') === 'DRAFT' ? 'selected' : '' }}>DRAFT</option>
                    <option value="CLOSED" {{ old('status') === 'CLOSED' ? 'selected' : '' }}>CLOSED</option>
                    <option value="ARCHIVED" {{ old('status') === 'ARCHIVED' ? 'selected' : '' }}>ARCHIVED</option>
                </select>
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Deskripsi & Instruksi Tugas *</label>
            <textarea name="description" rows="5" required placeholder="Tuliskan petunjuk pengerjaan tugas di sini..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">{{ old('description') }}</textarea>
            @error('description') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-600/20">
                SIMPAN & TERBITKAN TUGAS
            </button>
        </div>
    </form>
</div>
@endsection