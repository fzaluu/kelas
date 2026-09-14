<nav x-data="{ openMobile: false, openDropdown: null }" 
     @click.away="openDropdown = null"
     class="bg-white/90 backdrop-blur-md fixed top-0 left-0 right-0 z-50 border-b border-slate-100 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform duration-200">
                        P2
                    </div>
                    <span class="font-bold text-lg text-slate-800 tracking-tight group-hover:text-blue-600 transition-colors">XI PPLG 2</span>
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center space-x-6 text-sm font-medium text-slate-600">
                
                <!-- 🏠 Beranda -->
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600 transition' }}">
                    🏠 Beranda
                </a>

                <!-- 📖 Tentang -->
                <a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600 transition' }}">
                    📖 Tentang
                </a>

                <!-- 📢 Informasi (Dropdown) -->
                <div class="relative" @mouseenter="openDropdown = 'info'" @mouseleave="openDropdown = null">
                    <button class="flex items-center space-x-1 hover:text-blue-600 transition py-2 focus:outline-none {{ request()->routeIs('public.information.*') ? 'text-blue-600 font-semibold' : '' }}">
                        <span>📢 Informasi</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="openDropdown === 'info' ? 'rotate-180 text-blue-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="openDropdown === 'info'" 
                         x-transition:enter="animate-dropdown-in"
                         x-transition:leave="animate-dropdown-out"
                         class="absolute left-0 w-60 bg-white text-slate-700 rounded-2xl shadow-xl border border-slate-100 py-3 z-50" style="display: none;">
                        <a href="{{ route('public.information.announcements') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition">📢 Pengumuman</a>
                        <a href="{{ route('public.information.agendas') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition">📅 Agenda Kelas</a>
                        <a href="{{ route('public.information.tasks') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition">📚 Tugas Akademik</a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <a href="{{ route('public.information.schedules') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition">🗓️ Jadwal Pelajaran & Piket</a>
                    </div>
                </div>

                <!-- 🖼️ Galeri (Dropdown) -->
                <div class="relative" @mouseenter="openDropdown = 'gallery'" @mouseleave="openDropdown = null">
                    <button class="flex items-center space-x-1 hover:text-blue-600 transition py-2 focus:outline-none {{ request()->routeIs('public.gallery.*') ? 'text-blue-600 font-semibold' : '' }}">
                        <span>🖼️ Galeri</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="openDropdown === 'gallery' ? 'rotate-180 text-blue-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="openDropdown === 'gallery'" 
                         x-transition:enter="animate-dropdown-in"
                         x-transition:leave="animate-dropdown-out"
                         class="absolute left-0 w-52 bg-white text-slate-700 rounded-2xl shadow-xl border border-slate-100 py-3 z-50" style="display: none;">
                        <a href="{{ route('public.gallery.activities') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition">📸 Kegiatan Kelas</a>
                        <a href="{{ route('public.gallery.projects') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition">💻 Karya & Project</a>
                        <a href="{{ route('public.gallery.appreciations') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 transition">🏆 Prestasi Siswa</a>
                    </div>
                </div>

                <!-- 📞 Kontak -->
                <a href="{{ route('public.contact') }}" class="{{ request()->routeIs('public.contact') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600 transition' }}">
                    📞 Kontak
                </a>

            </div>

            <!-- Auth Action Button -->
            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ Auth::user()->hasRole('development') ? route('development.dashboard') : route('teacher.attendance.index') }}" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md shadow-blue-500/20 transition hover:scale-105 active:scale-95">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl transition hover:scale-105 active:scale-95">
                        Masuk Akun
                    </a>
                @endauth

                <!-- Mobile Hamburger Button -->
                <button @click="openMobile = !openMobile" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Drawer -->
    <div x-show="openMobile" x-transition class="md:hidden border-t border-slate-100 bg-white text-slate-800 px-4 pt-3 pb-6 space-y-3" style="display: none;">
        <a href="{{ route('home') }}" class="block px-3 py-2 text-sm font-bold rounded-lg hover:bg-slate-50">🏠 Beranda</a>
        <a href="{{ route('public.about') }}" class="block px-3 py-2 text-sm font-bold rounded-lg hover:bg-slate-50">📖 Tentang</a>
        
        <div class="space-y-1 pl-3 border-l-2 border-slate-100">
            <div class="text-xs font-bold text-blue-600 uppercase tracking-wider py-1">📢 Informasi</div>
            <a href="{{ route('public.information.announcements') }}" class="block px-3 py-1 text-xs text-slate-600 hover:text-blue-600">Pengumuman</a>
            <a href="{{ route('public.information.agendas') }}" class="block px-3 py-1 text-xs text-slate-600 hover:text-blue-600">Agenda Kelas</a>
            <a href="{{ route('public.information.tasks') }}" class="block px-3 py-1 text-xs text-slate-600 hover:text-blue-600">Tugas Akademik</a>
            <a href="{{ route('public.information.schedules') }}" class="block px-3 py-1 text-xs text-slate-600 hover:text-blue-600">Jadwal Pelajaran & Piket</a>
        </div>

        <div class="space-y-1 pl-3 border-l-2 border-slate-100">
            <div class="text-xs font-bold text-blue-600 uppercase tracking-wider py-1">🖼️ Galeri</div>
            <a href="{{ route('public.gallery.activities') }}" class="block px-3 py-1 text-xs text-slate-600 hover:text-blue-600">Kegiatan Kelas</a>
            <a href="{{ route('public.gallery.projects') }}" class="block px-3 py-1 text-xs text-slate-600 hover:text-blue-600">Karya & Project</a>
            <a href="{{ route('public.gallery.appreciations') }}" class="block px-3 py-1 text-xs text-slate-600 hover:text-blue-600">Prestasi Siswa</a>
        </div>

        <a href="{{ route('public.contact') }}" class="block px-3 py-2 text-sm font-bold rounded-lg hover:bg-slate-50">📞 Kontak</a>
    </div>
</nav>