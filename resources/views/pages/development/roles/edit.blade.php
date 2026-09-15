@extends('layouts.dashboard')

@section('title', 'Kelola Permission Role')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('development.roles.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition shadow-sm shrink-0">
            ⬅️
        </a>
        <div class="min-w-0">
            <h1 class="text-xl font-bold text-slate-900 truncate">Kelola Permission: {{ $role->name }}</h1>
            <p class="text-xs text-slate-500">Atur hak akses yang diizinkan untuk peranan <span class="font-bold text-slate-700">{{ strtoupper($role->slug) }}</span>.</p>
        </div>
    </div>

    <!-- Form Matriks Checkbox Permission -->
    <form action="{{ route('development.roles.update', $role->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @foreach($permissions as $resource => $permGroup)
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 sm:p-6 space-y-4">
            <!-- Resource Group Title -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600 shrink-0"></span>
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider">
                        Modul {{ $resource }}
                    </h3>
                </div>
                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full border border-slate-200/60">
                    {{ $permGroup->count() }} Izin
                </span>
            </div>

            <!-- Checkbox Grid (Fluid Responsif: 1 kolom di HP, 2 kolom di Laptop, 3 kolom di Layar Besar) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($permGroup as $perm)
                <label class="flex items-start space-x-3 p-3 rounded-xl border border-slate-200/80 hover:bg-blue-50/50 hover:border-blue-200 transition cursor-pointer group bg-slate-50/30">
                    <input type="checkbox" 
                           name="permissions[]" 
                           value="{{ $perm->id }}" 
                           {{ in_array($perm->id, $rolePermissions) ? 'checked' : '' }}
                           class="mt-0.5 w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 shrink-0 cursor-pointer">
                    
                    <div class="space-y-0.5 min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition leading-snug">
                            {{ $perm->name }}
                        </p>
                        <p class="text-[10px] text-slate-400 font-mono break-all leading-tight">
                            {{ $perm->slug }}
                        </p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <!-- Action Buttons (Sticky di layar HP/Desktop) -->
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('development.roles.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-md shadow-blue-600/20">
                Simpan Permasukan Permission
            </button>
        </div>
    </form>

</div>
@endsection