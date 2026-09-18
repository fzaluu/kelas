@extends('layouts.dashboard')

@section('title', 'Manajemen Role & Permission')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-xl font-bold text-slate-900">Modul Role & Hak Akses (RBAC)</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola peranan sistem dan atur pemetaan izin (permissions) untuk tiap role.</p>
    </div>

    <!-- Alert Notifikasi Session -->
    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <!-- Grid Card Roles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($roles as $role)
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-blue-50 text-blue-700 uppercase border border-blue-200">
                        {{ $role->slug }}
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold">
                        {{ $role->permissions->count() }} Permission
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900">{{ $role->name }}</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    {{ $role->description ?? 'Tidak ada deskripsi role.' }}
                </p>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                @if($role->slug === 'development')
                    <span class="w-full text-center text-[10px] font-bold text-amber-700 bg-amber-50 py-2 rounded-xl border border-amber-200">
                        Master Role (Absolut)
                    </span>
                @else
                    <a href="{{ route('development.roles.edit', $role->id) }}" class="w-full text-center px-3 py-2 rounded-xl bg-slate-100 hover:bg-blue-600 text-slate-700 hover:text-white font-bold text-xs transition">
                        Kelola Permission
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection