@extends('layouts.dashboard')

@section('title', 'Buat Pengumuman Baru - XI PPLG 2')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Buat Pengumuman Baru</h1>
            <p class="text-xs text-slate-500">Tulis pengumuman resmi untuk seluruh anggota kelas XI PPLG 2.</p>
        </div>
        <a href="{{ route('development.public.announcements.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition">
            Kembali
        </a>
    </div>

    <form action="{{ route('development.public.announcements.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        @csrf

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Judul Pengumuman *</label>
            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Pembayaran Iuran Kas Bulan Ini" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
            @error('title') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kategori *</label>
                <select name="category" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="GENERAL" {{ old('category') === 'GENERAL' ? 'selected' : '' }}>GENERAL</option>
                    <option value="ACADEMIC" {{ old('category') === 'ACADEMIC' ? 'selected' : '' }}>ACADEMIC</option>
                    <option value="EVENT" {{ old('category') === 'EVENT' ? 'selected' : '' }}>EVENT</option>
                    <option value="FINANCE" {{ old('category') === 'FINANCE' ? 'selected' : '' }}>FINANCE</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Prioritas *</label>
                <select name="priority" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="NORMAL" {{ old('priority') === 'NORMAL' ? 'selected' : '' }}>NORMAL</option>
                    <option value="IMPORTANT" {{ old('priority') === 'IMPORTANT' ? 'selected' : '' }}>IMPORTANT</option>
                    <option value="URGENT" {{ old('priority') === 'URGENT' ? 'selected' : '' }}>URGENT</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase">Status Publikasi *</label>
                <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 bg-white transition">
                    <option value="PUBLISHED" {{ old('status') === 'PUBLISHED' ? 'selected' : '' }}>PUBLISHED</option>
                    <option value="DRAFT" {{ old('status') === 'DRAFT' ? 'selected' : '' }}>DRAFT</option>
                </select>
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-700 uppercase">Isi Pengumuman *</label>
            <textarea name="content" rows="6" required placeholder="Tuliskan isi detail pengumuman di sini..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">{{ old('content') }}</textarea>
            @error('content') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-600/20">
                SIMPAN & DIPUBLIKASIKAN
            </button>
        </div>
    </form>
</div>
@endsection