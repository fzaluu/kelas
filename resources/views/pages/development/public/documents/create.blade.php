@extends('layouts.dashboard')

@section('title', 'Tambah Dokumen Baru - XI PPLG 2')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Dokumen Baru</h1>
            <p class="text-xs text-slate-500">Hubungkan file dari Media Manager ke arsip publik kelas.</p>
        </div>
        <a href="{{ route('development.public.documents.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('development.public.documents.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        @csrf

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Judul Dokumen *</label>
            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Modul Pemrograman Web XI PPLG 2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kategori *</label>
                <select name="category" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white">
                    <option value="ADMINISTRATION">ADMINISTRATION</option>
                    <option value="STUDENT">STUDENT</option>
                    <option value="ARCHIVE">ARCHIVE</option>
                    <option value="OTHER">OTHER</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Status Publikasi *</label>
                <select name="status" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white">
                    <option value="ACTIVE">ACTIVE (Aktif / Publik)</option>
                    <option value="ARCHIVED">ARCHIVED (Diarsipkan)</option>
                </select>
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Pilih File dari Media Storage *</label>
            <select name="media_file_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white">
                <option value="">-- Pilih File Berkas --</option>
                @foreach($mediaFiles as $media)
                    <option value="{{ $media->id }}" {{ old('media_file_id') == $media->id ? 'selected' : '' }}>
                        📁 {{ $media->original_name }} ({{ number_format($media->file_size / 1024, 1) }} KB)
                    </option>
                @endforeach
            </select>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Deskripsi Dokumen</label>
            <textarea name="description" rows="4" placeholder="Keterangan isi file dokumen..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">{{ old('description') }}</textarea>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">
                Simpan Dokumen 🚀
            </button>
        </div>
    </form>
</div>
@endsection