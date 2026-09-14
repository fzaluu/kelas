@extends('layouts.public')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-16 bg-gradient-to-b from-blue-50/50 via-white to-slate-50">
    <div class="max-w-lg w-full text-center space-y-6">
        <div class="w-24 h-24 rounded-3xl bg-blue-100 text-blue-600 font-extrabold text-4xl flex items-center justify-center mx-auto shadow-inner">
            404
        </div>
        
        <div class="space-y-2">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Halaman Tidak Ditemukan</h1>
            <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
                Tautan yang Anda tuju tidak ada, telah dipindahkan, atau alamat URL yang dimasukkan salah.
            </p>
        </div>

        <div class="pt-2 flex justify-center space-x-3">
            <a href="{{ route('home') }}" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-blue-500/20 transition hover:scale-105 active:scale-95">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection