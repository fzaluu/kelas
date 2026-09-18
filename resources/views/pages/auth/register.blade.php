<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Anggota Kelas - XI PPLG 2</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50/70 via-slate-100 to-indigo-50/60 min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased font-sans">

    <!-- Decorative Soft Blobs -->
    <div class="fixed top-1/4 -left-20 w-80 h-80 bg-blue-400/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed bottom-1/4 -right-20 w-80 h-80 bg-indigo-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Register Box Card -->
    <div class="relative z-10 w-full max-w-md bg-white p-6 sm:p-8 rounded-3xl shadow-xl shadow-blue-950/5 border border-slate-200/80 space-y-5">
        
        <!-- Header & Back Link -->
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
                P2
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Pendaftaran Anggota</h1>
                <p class="text-[11px] text-slate-500">Isi data diri untuk mengajukan akun siswa XI PPLG 2</p>
            </div>
        </div>

        <!-- FORM REGISTRATION -->
        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- NIS & Gender -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">NIS *</label>
                    <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Contoh: 22231001" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition" required>
                    @error('nis') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">JENIS KELAMIN *</label>
                    <select name="gender" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition" required>
                        <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div class="space-y-1">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">NAMA LENGKAP *</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Nama siswa" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition" required>
                @error('full_name') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Username & Email -->
            <div class="space-y-1">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">USERNAME *</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Username login" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition" required>
                @error('username') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">EMAIL *</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@smkn4tasikmalaya.sch.id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition" required>
                @error('email') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Password & Konfirmasi (Masing-masing memiliki Toggle Mata SVG) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Kata Sandi -->
                <div class="space-y-1">
                    <label for="regPassInput" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">KATA SANDI *</label>
                    <div class="relative">
                        <input type="password" 
                               id="regPassInput" 
                               name="password" 
                               placeholder="••••••••" 
                               class="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition" 
                               required>
                        <button type="button" 
                                data-toggle-password="regPassInput"
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
                    @error('password') <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div class="space-y-1">
                    <label for="regPassConfirmInput" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">KONFIRMASI *</label>
                    <div class="relative">
                        <input type="password" 
                               id="regPassConfirmInput" 
                               name="password_confirmation" 
                               placeholder="••••••••" 
                               class="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition" 
                               required>
                        <button type="button" 
                                data-toggle-password="regPassConfirmInput"
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
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 transition hover:scale-[1.01] active:scale-[0.99]">
                KIRIM PENGAJUAN PENDAFTARAN →
            </button>
        </form>

        <div class="text-center pt-3 border-t border-slate-100 space-y-1">
            <p class="text-xs text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline">Masuk Login</a>
            </p>
        </div>

    </div>

</body>
</html>