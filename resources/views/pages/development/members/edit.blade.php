@extends('layouts.dashboard')

@section('title', 'Edit Anggota Kelas')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center space-x-3">
        <a href="{{ route('development.members.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition shrink-0">
            ⬅️
        </a>
        <div class="min-w-0">
            <h1 class="text-xl font-bold text-slate-900 truncate">Edit Data Siswa</h1>
            <p class="text-xs text-slate-500">Ubah biodata atau status dari {{ $member->full_name }}.</p>
        </div>
    </div>

    <form action="{{ route('development.members.update', $member->id) }}" method="POST" class="bg-white p-5 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- NIS (Wajib) -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">NIS <span class="text-rose-500">*</span></label>
                <input type="text" name="nis" value="{{ old('nis', $member->nis) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" required>
                <p class="text-[10px] text-slate-400">Nomor induk sekolah (digunakan untuk absensi).</p>
                @error('nis') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- NISN (Opsional) -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">NISN <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                <input type="text" name="nisn" value="{{ old('nisn', $member->nisn) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                <p class="text-[10px] text-slate-400">Boleh dikosongkan jika siswa tidak tahu NISN-nya.</p>
                @error('nisn') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Nama Lengkap -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Lengkap <span class="text-rose-500">*</span></label>
            <input type="text" name="full_name" value="{{ old('full_name', $member->full_name) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" required>
            @error('full_name') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Gender -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Jenis Kelamin <span class="text-rose-500">*</span></label>
                <select name="gender" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white" required>
                    <option value="L" {{ old('gender', $member->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', $member->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- 🔍 HUBUNGKAN KE AKUN (MODULAR REUSABLE LIVE SEARCH DROPDOWN EDIT) -->
            @php
                $selectedUser = $users->firstWhere('id', old('user_id', $member->user_id));
                $displayText = $selectedUser ? $selectedUser->username . ' (' . ($selectedUser->email ?? 'Tanpa Email') . ')' : '-- Tanpa Akun --';
            @endphp
            <div class="space-y-1 relative" data-live-search="true">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Hubungkan ke Akun (Opsional)</label>

                <input type="hidden" name="user_id" class="select-real-input" value="{{ old('user_id', $member->user_id) }}">

                <div class="select-trigger-btn w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs bg-white cursor-pointer flex items-center justify-between shadow-sm hover:border-blue-400 transition">
                    <span class="select-display-text truncate font-medium text-slate-800">{{ $displayText }}</span>
                    <span class="text-slate-400 text-[10px]">▼</span>
                </div>

                <div class="select-dropdown-menu hidden absolute left-0 right-0 mt-1 bg-white border border-slate-200 rounded-xl shadow-2xl z-50 p-2 space-y-2 max-h-56 overflow-hidden flex flex-col">
                    <div class="relative shrink-0">
                        <input type="text" 
                               placeholder="Ketik username / email..." 
                               autocomplete="off"
                               class="select-search-input w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
                    </div>

                    <div class="overflow-y-auto flex-1 space-y-0.5">
                        <div class="select-option-item px-3 py-2 text-xs rounded-lg hover:bg-blue-50 hover:text-blue-600 cursor-pointer font-medium transition text-slate-700" 
                             data-id="" 
                             data-text="-- Tanpa Akun --">
                            -- Tanpa Akun --
                        </div>

                        @foreach($users as $user)
                        <div class="select-option-item px-3 py-2 text-xs rounded-lg hover:bg-blue-50 hover:text-blue-600 cursor-pointer font-medium transition text-slate-700 {{ old('user_id', $member->user_id) == $user->id ? 'bg-blue-50 text-blue-600 font-bold' : '' }}" 
                             data-id="{{ $user->id }}" 
                             data-text="{{ $user->username }} ({{ $user->email ?? 'Tanpa Email' }})">
                            {{ $user->username }} <span class="text-slate-400 text-[10px]">({{ $user->email ?? 'Tanpa Email' }})</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                @error('user_id') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Tempat Lahir -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Tempat Lahir</label>
                <input type="text" name="pob" value="{{ old('pob', $member->pob) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>

            <!-- Tanggal Lahir -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Lahir</label>
                <input type="date" name="dob" value="{{ old('dob', $member->dob) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>
        </div>

        <!-- Alamat -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Alamat Lengkap</label>
            <textarea name="address" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">{{ old('address', $member->address) }}</textarea>
        </div>

        <!-- Status -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Status Siswa <span class="text-rose-500">*</span></label>
            <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white" required>
                <option value="ACTIVE" {{ old('status', $member->status) === 'ACTIVE' ? 'selected' : '' }}>ACTIVE (Aktif)</option>
                <option value="GRADUATED" {{ old('status', $member->status) === 'GRADUATED' ? 'selected' : '' }}>GRADUATED (Lulus)</option>
                <option value="TRANSFERRED" {{ old('status', $member->status) === 'TRANSFERRED' ? 'selected' : '' }}>TRANSFERRED (Pindah)</option>
                <option value="DROPPED_OUT" {{ old('status', $member->status) === 'DROPPED_OUT' ? 'selected' : '' }}>DROPPED_OUT (Keluar)</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('development.members.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-md shadow-blue-600/20">
                Update Data Siswa
            </button>
        </div>
    </form>
</div>
@endsection