@extends('layouts.dashboard')

@section('title', 'Tambah User Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center space-x-3">
        <a href="{{ route('development.users.index') }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
            Kembali
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Akun Pengguna</h1>
            <p class="text-xs text-slate-500">Buat kredensial login baru dan hubungkan dengan data anggota kelas.</p>
        </div>
    </div>

    <form action="{{ route('development.users.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
        @csrf

        <!-- Hubungkan Anggota Kelas -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Anggota Kelas (Siswa)</label>
            <select name="member_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white">
                <option value="">-- Non-Member (Akun Developer / Wali Kelas) --</option>
                @foreach($unlinkedMembers as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->name }} (NIS: {{ $member->nis ?? '-' }})
                    </option>
                @endforeach
            </select>
            @error('member_id') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Username -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Username <span class="text-rose-500">*</span></label>
            <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: user_budi" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" required>
            @error('username') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Email (Opsional)</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="user@smkn4tasikmalaya.sch.id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
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

        <!-- Status -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Status Akun <span class="text-rose-500">*</span></label>
            <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white" required>
                <option value="ACTIVE" selected>ACTIVE</option>
                <option value="INACTIVE">INACTIVE</option>
                <option value="SUSPENDED">SUSPENDED</option>
            </select>
            @error('status') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Password <span class="text-rose-500">*</span></label>
            <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none" required>
            @error('password') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('development.users.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-md">
                Simpan User
            </button>
        </div>

    </form>
</div>
@endsection