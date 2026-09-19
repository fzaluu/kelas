@extends('layouts.dashboard')

@section('title', 'Tambah Konten Galeri - XI PPLG 2')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Foto Kegiatan Baru</h1>
            <p class="text-xs text-slate-500">Unggah foto dokumentasi kegiatan kelas XI PPLG 2 ke galeri visual.</p>
        </div>
        <a href="{{ route('development.public.galleries.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('development.public.galleries.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        @csrf

        <!-- Judul Konten -->
        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Judul Kegiatan *</label>
            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Kunjungan Industri / Class Meeting 2026" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
            @error('title') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Pilihan Kategori, Status & Akses -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kategori *</label>
                <select name="category" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="ACTIVITY" {{ old('category') === 'ACTIVITY' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="OTHER" {{ old('category') === 'OTHER' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Status *</label>
                <select name="status" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLISHED" {{ old('status') === 'PUBLISHED' ? 'selected' : '' }}>Diterbitkan</option>
                    <option value="DRAFT" {{ old('status') === 'DRAFT' ? 'selected' : '' }}>Draf (Konsep)</option>
                    <option value="ARCHIVED" {{ old('status') === 'ARCHIVED' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Akses *</label>
                <select name="visibility" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLIC" {{ old('visibility') === 'PUBLIC' ? 'selected' : '' }}>Publik (Semua Orang)</option>
                    <option value="MEMBER" {{ old('visibility') === 'MEMBER' ? 'selected' : '' }}>Khusus Anggota Kelas</option>
                    <option value="RESTRICTED" {{ old('visibility') === 'RESTRICTED' ? 'selected' : '' }}>Terbatas</option>
                </select>
            </div>
        </div>

        <!-- Media Gambar -->
        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Pilih Gambar dari Storage *</label>
            <select name="media_file_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                <option value="">-- Pilih Berkas Gambar --</option>
                @foreach($imageFiles as $media)
                    <option value="{{ $media->id }}" {{ old('media_file_id') == $media->id ? 'selected' : '' }}>
                        {{ $media->original_name }} ({{ number_format(($media->size ?? $media->file_size) / 1024, 1) }} KB)
                    </option>
                @endforeach
            </select>
            @error('media_file_id') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Deskripsi -->
        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi / Keterangan Konten</label>
            <textarea name="description" rows="3" placeholder="Tuliskan keterangan detail mengenai dokumentasi kegiatan ini..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">{{ old('description') }}</textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="pt-2 flex justify-end space-x-2">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-600/20">
                SIMPAN DAN TERBITKAN
            </button>
        </div>
    </form>
</div>
@endsection