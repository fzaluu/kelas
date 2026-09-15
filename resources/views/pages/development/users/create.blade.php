@extends('layouts.dashboard')

@section('title', 'Tambah User Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center space-x-3">
        <a href="{{ route('development.users.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
            ⬅️
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Akun Pengguna</h1>
            <p class="text-xs text-slate-500">Buat kredensial login baru dan tetapkan peranannya.</p>
        </div>
    </div>

    <form action="{{ route('development.users.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
        @csrf

        <!-- Username -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Username <span class="text-rose-500">*</span></label>
            <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: siswa_budi" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" required>
            @error('username') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Nama Lengkap -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            @error('name') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Email (Opsional)</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="budi@smkn4tasikmalaya.sch.id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            @error('email') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Role / Hak Akses -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Role / Hak Akses <span class="text-rose-500">*</span></label>
            <select name="role_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white" required>
                <option value="">-- Pilih Role / Hak Akses --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ strtoupper($role->name) }} @if($role->description) - ({{ $role->description }}) @endif
                    </option>
                @endforeach
            </select>
            @error('role_id') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Password (Sesuai Halaman Login) -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Password <span class="text-rose-500">*</span></label>
            <div class="relative">
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Minimal 8 karakter" 
                       class="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" 
                       required>

                <!-- Tombol Toggle Mata (Vanilla JS / auth-utils.js) -->
                <button type="button" 
                        id="togglePasswordBtn"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 p-1 focus:outline-none transition cursor-pointer">
                    
                    <!-- 👁️ Mata Terbuka (Default Password Dots) -->
                    <svg id="eyeOpenIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>

                    <!-- 🙈 Mata Dicoret (Saat Password Text) -->
                    <svg id="eyeSlashIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.682-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-6.621-1.396a3 3 0 104.243-4.243M3 3l18 18"/>
                    </svg>
                </button>
            </div>
            @error('password') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('development.users.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-md shadow-blue-600/20">
                Simpan User
            </button>
        </div>

    </form>
</div>
@endsection