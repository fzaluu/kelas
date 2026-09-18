<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi - Portal XI PPLG 2</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50/70 via-slate-100 to-indigo-50/60 min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased font-sans">

    <div class="fixed top-1/4 -left-20 w-80 h-80 bg-blue-400/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed bottom-1/4 -right-20 w-80 h-80 bg-indigo-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-sm bg-white p-6 sm:p-8 rounded-3xl shadow-xl shadow-blue-950/5 border border-slate-200/80 space-y-5">
        
        <div class="flex justify-between items-center">
            <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-400 hover:text-blue-600 transition flex items-center space-x-1">
                <span>← Kembali ke Login</span>
            </a>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 uppercase border border-blue-100">
                SMKN 4 Tasikmalaya
            </span>
        </div>

        <div class="text-center space-y-1.5">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-700 to-blue-500 text-white font-black text-xl flex items-center justify-center mx-auto shadow-md shadow-blue-500/20">
                🔑
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Lupa Kata Sandi</h1>
                <p class="text-[11px] text-slate-500">Verifikasi email & NISN Anda untuk mereset kata sandi</p>
            </div>
        </div>

        @if(session('error'))
            <div class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start space-x-2">
                <span class="shrink-0 text-sm">⚠️</span>
                <span class="text-[11px] font-medium leading-relaxed">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf

            <!-- 1. Email / Username -->
            <div class="space-y-1">
                <label for="identity" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                    EMAIL / USERNAME *
                </label>
                <input type="text" 
                       id="identity" 
                       name="identity" 
                       value="{{ old('identity') }}" 
                       required 
                       autofocus 
                       placeholder="email@pplg.sch.id / username" 
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
                @error('identity') <p class="text-[10px] text-rose-500 font-semibold mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- 2. Dynamic Input: NISN vs KODE DEV -->
            @if($useDevCode)
                <!-- Mode Kode Dev (Jika NISN Salah 5x) -->
                <div class="space-y-1">
                    <label for="dev_code" class="block text-[11px] font-bold text-amber-600 uppercase tracking-wider flex items-center justify-between">
                        <span>KODE DEV *</span>
                        <span class="text-[9px] font-normal text-slate-400">(NISN Terkunci 5x)</span>
                    </label>
                    <input type="password" 
                           id="dev_code" 
                           name="dev_code" 
                           required 
                           placeholder="Masukkan Kode Dev..." 
                           class="w-full px-3.5 py-2.5 rounded-xl border border-amber-300 bg-amber-50/30 text-xs focus:bg-white focus:outline-none focus:border-amber-600 focus:ring-2 focus:ring-amber-600/20 transition">
                    @error('dev_code') <p class="text-[10px] text-rose-500 font-semibold mt-1">{{ $message }}</p> @enderror
                </div>
            @else
                <!-- Mode NISN Standard -->
                <div class="space-y-1">
                    <label for="nisn" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                        NISN SISWA *
                    </label>
                    <input type="text" 
                           id="nisn" 
                           name="nisn" 
                           value="{{ old('nisn') }}" 
                           required 
                           placeholder="Contoh: 0061234567" 
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
                    @error('nisn') <p class="text-[10px] text-rose-500 font-semibold mt-1">{{ $message }}</p> @enderror
                </div>
            @endif

            <button type="submit" class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 transition hover:scale-[1.01] active:scale-[0.99]">
                VERIFIKASI AKUN →
            </button>
        </form>

    </div>

</body>
</html>