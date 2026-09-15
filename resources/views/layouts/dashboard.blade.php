<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Portal XI PPLG 2</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-100 min-h-screen font-sans antialiased text-slate-800" x-data="{ mobileDrawer: false }">

    <div class="flex min-h-screen pb-16 md:pb-0">

        <!-- 🖥️ DESKTOP SIDEBAR -->
         <aside class="w-64 bg-slate-900 text-slate-300 flex-col justify-between hidden md:flex shrink-0 border-r border-slate-800 sticky top-0 h-screen overflow-y-auto">
            <div>
                <div class="p-6 border-b border-slate-800 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 to-blue-500 text-white font-black text-lg flex items-center justify-center shadow-md shadow-blue-600/30">
                        P2
                    </div>
                    <div>
                        <h2 class="font-extrabold text-white text-sm tracking-wide">XI PPLG 2</h2>
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-bold bg-blue-900/60 text-blue-300 uppercase tracking-wider border border-blue-700/50">
                            {{ Auth::user()->role ?? 'Development' }}
                        </span>
                    </div>
                </div>

                <nav class="p-4 space-y-1.5 text-xs">
                    @include('partials.sidebar-menu')
                </nav>
            </div>

            <div class="p-4 border-t border-slate-800">
                <a href="{{ route('home') }}" class="flex items-center justify-center space-x-2 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-300 transition">
                    <span>🌐</span>
                    <span>Lihat Web Publik</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- TOPBAR -->
            <header class="h-16 bg-white border-b border-slate-200/80 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-20 shadow-sm">
                <div class="flex items-center space-x-3">
                    <button @click="mobileDrawer = true" class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 md:hidden focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-sm font-bold text-slate-800">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-slate-900 leading-none">{{ Auth::user()->name ?? Auth::user()->username }}</p>
                        <span class="text-[10px] text-emerald-600 font-semibold">● Sesi Aktif</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-4 sm:p-8 flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- 📱 MOBILE BOTTOM NAVIGATION -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-around z-30 shadow-lg px-2">
        <a href="{{ route('development.dashboard') }}" class="flex flex-col items-center text-slate-500 hover:text-blue-600 space-y-0.5">
            <span class="text-lg">🏠</span>
            <span class="text-[10px] font-semibold">Home</span>
        </a>
        <a href="{{ route('development.users.index') }}" class="flex flex-col items-center text-slate-500 hover:text-blue-600 space-y-0.5">
            <span class="text-lg">👥</span>
            <span class="text-[10px] font-semibold">Users</span>
        </a>
        <div class="relative -top-3">
            <a href="{{ route('development.users.create') }}" class="w-13 h-13 rounded-full bg-gradient-to-tr from-blue-700 to-blue-500 text-white font-bold flex items-center justify-center shadow-lg shadow-blue-600/40 border-4 border-slate-100 active:scale-95 transition">
                <span class="text-xl">➕</span>
            </a>
        </div>
        <a href="#" class="flex flex-col items-center text-slate-500 hover:text-blue-600 space-y-0.5">
            <span class="text-lg">📋</span>
            <span class="text-[10px] font-semibold">Logs</span>
        </a>
        <button @click="mobileDrawer = true" class="flex flex-col items-center text-slate-500 hover:text-blue-600 space-y-0.5 focus:outline-none">
            <span class="text-lg">☰</span>
            <span class="text-[10px] font-semibold">Lainnya</span>
        </button>
    </nav>

    <!-- 📱 MOBILE DRAWER -->
    <div x-show="mobileDrawer" x-cloak class="fixed inset-0 z-50 md:hidden flex">
        <div x-show="mobileDrawer" @click="mobileDrawer = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div x-show="mobileDrawer" class="relative max-w-xs w-full bg-slate-900 text-slate-300 p-6 flex flex-col justify-between space-y-6 shadow-2xl">
            <div>
                <div class="flex justify-between items-center pb-4 border-b border-slate-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 text-white font-black text-sm flex items-center justify-center">P2</div>
                        <span class="font-bold text-white text-sm">Navigasi Lengkap</span>
                    </div>
                    <button @click="mobileDrawer = false" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
                </div>
                <nav class="mt-6 space-y-1 text-xs">
                    @include('partials.sidebar-menu')
                </nav>
            </div>
            <div class="pt-4 border-t border-slate-800">
                <a href="{{ route('home') }}" class="flex items-center justify-center space-x-2 py-2.5 rounded-xl bg-slate-800 text-xs font-semibold text-slate-300">
                    <span>🌐</span>
                    <span>Lihat Web Publik</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 🔔 GLOBAL FLOATING TOAST POP-UP (NATIVE VANILLA JS - PASTI MUNCUL & OTOMATIS HILANG 6 DETIK) -->
    @if(session('success') || session('error'))
    <div id="globalToast" 
         class="fixed top-20 right-6 z-[9999] max-w-sm w-full bg-white rounded-2xl shadow-2xl border-2 p-4 flex items-center space-x-3 transition-all duration-300 transform translate-y-0 opacity-100 {{ session('success') ? 'border-emerald-500/40 text-emerald-900 shadow-emerald-500/10' : 'border-rose-500/40 text-rose-900 shadow-rose-500/10' }}">
        
        <!-- Icon Status -->
        <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center font-bold text-base shadow-sm {{ session('success') ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
            {{ session('success') ? '✅' : '⚠️' }}
        </div>

        <!-- Pesan Dinamis -->
        <div class="flex-1 text-xs font-bold leading-relaxed">
            {{ session('success') ?? session('error') }}
        </div>

        <!-- Tombol Close Manual -->
        <button onclick="closeGlobalToast()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition font-bold text-sm focus:outline-none">
            ✕
        </button>
    </div>

    <script>
        function closeGlobalToast() {
            const toast = document.getElementById('globalToast');
            if (toast) {
                toast.classList.add('opacity-0', '-translate-y-4');
                setTimeout(() => toast.remove(), 300);
            }
        }

        // Otomatis tutup setelah tepat 6 detik (6000 milidetik) jika tidak di-close manual
        setTimeout(() => {
            closeGlobalToast();
        }, 6000);
    </script>
    @endif

</body>
</html>