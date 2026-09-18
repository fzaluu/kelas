@extends('layouts.dashboard')

@section('title', 'Tambah Anggota Kelas')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('development.members.index') }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
            Kembali
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Anggota Kelas Baru</h1>
            <p class="text-xs text-slate-500">Masukkan data identitas resmi siswa ke dalam database kelas.</p>
        </div>
    </div>

    <form action="{{ route('development.members.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        @csrf

        <input type="hidden" name="class_id" value="{{ $classes->first()->id ?? 1 }}">

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500">
            @error('name') <span class="text-rose-600 text-[10px]">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">NIS (Internal)</label>
                <input type="text" name="nis" value="{{ old('nis') }}" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500">
                @error('nis') <span class="text-rose-600 text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">NISN (Internal)</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500">
                @error('nisn') <span class="text-rose-600 text-[10px]">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin *</label>
                <select name="gender" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Status Keanggotaan *</label>
                <select name="member_status" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="ACTIVE" selected>ACTIVE</option>
                    <option value="INACTIVE">INACTIVE</option>
                    <option value="GRADUATED">GRADUATED</option>
                    <option value="TRANSFERRED">TRANSFERRED</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Bio Publik (Opsional)</label>
            <textarea name="public_bio" rows="2" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500">{{ old('public_bio') }}</textarea>
        </div>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('development.members.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold">Simpan Anggota</button>
        </div>
    </form>
</div>
@endsection