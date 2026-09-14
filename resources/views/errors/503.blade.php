@extends('layouts.public')

@section('title', '503 - Pemeliharaan Sistem')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-16 bg-gradient-to-b from-blue-50/50 via-white to-slate-50">
    <div class="max-w-lg w-full text-center space-y-6">
        <div class="w-24 h-24 rounded-3xl bg-indigo-100 text-indigo-600 font-extrabold text-4xl flex items-center justify-center mx-auto shadow-inner">
            🛠️
        </div>
        
        <div class="space-y-2">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Sistem Dalam Pemeliharaan</h1>
            <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
                Website XI PPLG 2 sedang dalam proses pembaruan fitur. Kami akan kembali online sebentar lagi.
            </p>
        </div>

        <div class="pt-2">
            <span class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs">
                Status: Pembaruan Rutin
            </span>
        </div>
    </div>
</div>
@endsection