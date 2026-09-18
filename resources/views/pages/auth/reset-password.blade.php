<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Kata Sandi Baru - Portal XI PPLG 2</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50/70 via-slate-100 to-indigo-50/60 min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased font-sans">

    <div class="fixed top-1/4 -left-20 w-80 h-80 bg-blue-400/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed bottom-1/4 -right-20 w-80 h-80 bg-indigo-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-sm bg-white p-6 sm:p-8 rounded-3xl shadow-xl shadow-blue-950/5 border border-slate-200/80 space-y-5">
        
        <div class="text-center space-y-1.5">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-700 to-blue-500 text-white font-black text-xl flex items-center justify-center mx-auto shadow-md shadow-blue-500/20">
                P2
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Buat Kata Sandi Baru</h1>
                <p class="text-[11px] text-slate-500">Masukkan kata sandi baru untuk akun Anda</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium leading-tight">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="space-y-1">
                <label for="newPassInput" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                    KATA SANDI BARU *
                </label>
                <div class="relative">
                    <input type="password" 
                           id="newPassInput" 
                           name="password" 
                           placeholder="Minimal 6 karakter" 
                           required 
                           class="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
                    <button type="button" 
                            data-toggle-password="newPassInput" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 p-1 focus:outline-none transition cursor-pointer">
                        <svg class="eye-open-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg class="eye-slash-icon w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.682-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-6.621-1.396a3 3 0 104.243-4.243M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
                @error('password') <p class="text-[10px] text-rose-500 font-semibold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label for="confirmPassInput" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                    KONFIRMASI KATA SANDI *
                </label>
                <div class="relative">
                    <input type="password" 
                           id="confirmPassInput" 
                           name="password_confirmation" 
                           placeholder="Ketik ulang password baru" 
                           required 
                           class="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition">
                    <button type="button" 
                            data-toggle-password="confirmPassInput" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 p-1 focus:outline-none transition cursor-pointer">
                        <svg class="eye-open-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg class="eye-slash-icon w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.682-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-6.621-1.396a3 3 0 104.243-4.243M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 transition hover:scale-[1.01] active:scale-[0.99]">
                SIMPAN PASSWORD BARU
            </button>
        </form>

    </div>

</body>
</html>