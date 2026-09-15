@extends('layouts.dashboard')

@section('title', 'Developer Overview')

@section('content')
<div class="space-y-6">

    <!-- Hero Greeting Card -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 text-white shadow-xl shadow-blue-600/15 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 space-y-2">
            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-white/20 uppercase tracking-widest backdrop-blur-md">
                Administrator Environment
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name ?? Auth::user()->username }}! 👋</h1>
            <p class="text-xs sm:text-sm text-blue-100 max-w-xl leading-relaxed">
                Selamat datang di Control Center Website Kelas XI PPLG 2. Seluruh modul platform dan infrastruktur berada di bawah pengawasan Anda.
            </p>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Environment</span>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
            </div>
            <div>
                <p class="text-xl font-black text-slate-900">Laravel 13</p>
                <p class="text-xs text-slate-500 font-medium">PHP v8.3.16 (Vite Engine)</p>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Akun</span>
                <span class="text-blue-600 text-sm font-bold">👥</span>
            </div>
            <div>
                <p class="text-xl font-black text-slate-900">{{ $totalUsers ?? 1 }} User</p>
                <p class="text-xs text-slate-500 font-medium">Terdaftar di Database</p>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Database</span>
                <span class="text-emerald-600 text-xs font-bold">MySQL</span>
            </div>
            <div>
                <p class="text-xl font-black text-slate-900">Connected</p>
                <p class="text-xs text-emerald-600 font-semibold">Port 3306 (DB: kelas)</p>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Keamanan</span>
                <span class="text-indigo-600 text-sm font-bold">🛡️</span>
            </div>
            <div>
                <p class="text-xl font-black text-slate-900">Active Throttle</p>
                <p class="text-xs text-slate-500 font-medium">Rate Limiting 5x / 120s</p>
            </div>
        </div>

    </div>

</div>
@endsection