@extends('layouts.dashboard')

@section('title', 'Tambah Karya Siswa - Admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Karya / Project Siswa</h1>
            <p class="text-xs text-slate-500">Publikasikan karya web, mobile, atau game buatan siswa XI PPLG 2.</p>
        </div>
        <a href="{{ route('development.content.projects.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition">← Kembali</a>
    </div>

    <form action="{{ route('development.content.projects.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        @csrf

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Judul Project *</label>
            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Aplikasi Kasir Gym / Website Portfolio" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 transition">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Status *</label>
                <select name="status" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLISHED">Diterbitkan</option>
                    <option value="DRAFT">Draf (Konsep)</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Akses *</label>
                <select name="visibility" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLIC">Publik (Semua Orang)</option>
                    <option value="MEMBER">Khusus Anggota Kelas</option>
                </select>
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Pilih Thumbnail / Gambar Cover *</label>
            <select name="media_file_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                <option value="">-- Pilih Berkas Gambar --</option>
                @foreach($imageFiles as $media)
                    <option value="{{ $media->id }}">{{ $media->original_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Pilih Tim Pengembang (Siswa)</label>
            <select name="member_ids[]" multiple class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition h-28">
                @foreach($members as $m)
                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->nis }})</option>
                @endforeach
            </select>
            <span class="text-[10px] text-slate-400 block">*Tekan Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari 1 siswa.</span>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi Karya *</label>
            <textarea name="description" rows="3" required placeholder="Jelaskan mengenai fitur, teknologi, dan keunggulan karya ini..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 transition">{{ old('description') }}</textarea>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-600/20">
                SIMPAN KARYA
            </button>
        </div>
    </form>
</div>
@endsection