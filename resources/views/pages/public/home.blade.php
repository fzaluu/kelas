@extends('layouts.public')

@section('title', 'Beranda Utama - XI PPLG 2')

@section('content')

<!-- HERO SECTION (TRANSPARENT FLOATING NAVBAR FIT) -->
<section class="relative bg-slate-900 text-white pt-32 pb-24 overflow-hidden">
    <!-- Background Image dengan Overlay Gelap -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=2070&auto=format&fit=crop" 
             alt="XI PPLG 2 Hero Background" 
             class="w-full h-full object-cover object-center opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-900/60 to-slate-900"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <div>
            <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-blue-600/40 text-blue-300 border border-blue-500/30 uppercase tracking-wider inline-block backdrop-blur-sm">
                SMKN 4 TASIKMALAYA • XI PPLG 2
            </span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight leading-none text-white drop-shadow-md">
            Pengembangan Perangkat Lunak <br class="hidden sm:block"> & Gim <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-blue-200">
                Generasi Unggul & Kreatif
            </span>
        </h1>

        <p class="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
            Wadah resmi transparansi akademik, pusat presensi digital harian, dokumentasi karya perangkat lunak, serta portofolio kegiatan siswa XI PPLG 2.
        </p>

        <div class="pt-4 flex justify-center items-center space-x-4">
            <a href="{{ route('public.about') }}" class="px-6 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-600/30 transition hover:scale-105 active:scale-95">
                Jelajahi Profil Kelas →
            </a>
            <a href="{{ route('public.information.announcements') }}" class="px-6 py-3.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-xs uppercase tracking-wider transition hover:scale-105 active:scale-95 backdrop-blur-sm">
                Lihat Informasi
            </a>
        </div>
    </div>
</section>

<!-- 2. QUICK FACTS SECTION -->
<section class="py-12 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="text-3xl sm:text-4xl font-extrabold text-blue-600 mb-1">{{ $totalMembers ?? 32 }}</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Siswa Aktif</div>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="text-3xl sm:text-4xl font-extrabold text-blue-600 mb-1">2024/2026</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Tahun Angkatan</div>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="text-3xl sm:text-4xl font-extrabold text-blue-600 mb-1">PPLG 2</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Rombongan Belajar</div>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="text-3xl sm:text-4xl font-extrabold text-blue-600 mb-1">100%</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Digital Ecosystem</div>
            </div>
        </div>
    </div>
</section>

<!-- 3. TENTANG SINGKAT -->
<section class="py-16 bg-slate-50 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-4 max-w-2xl">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Tentang XI PPLG 2</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Membangun Masa Depan Software Engineering Berintegritas</h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    {{ $profile->vision ?? 'Fokus pada penguasaan pemrograman web, aplikasi mobile, basis data, dan pengembangan gim.' }}
                </p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('public.about') }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm transition hover:scale-105 active:scale-95">
                    Lihat Profil Selengkapnya →
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 4. INFORMASI TERBARU (Pengumuman, Agenda) -->
<section class="py-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Update Terbaru</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Pengumuman & Agenda Terdekat</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Pengumuman items -->
            @forelse ($announcements as $ann)
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="px-3 py-1 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800 uppercase">{{ $ann->priority }}</span>
                        <span class="text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($ann->published_at)->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 line-clamp-1">{{ $ann->title }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">{{ Str::limit(strip_tags($ann->content), 100) }}</p>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-xs text-slate-400 border border-dashed border-slate-200 rounded-2xl">
                    Belum ada pengumuman publik terbaru.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 5. AKTIVITAS & MOMEN (Galeri Album Preview) -->
<section class="py-16 bg-slate-50 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Dokumentasi</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Aktivitas & Momen Kebersamaan</h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse ($galleries as $gal)
                <div class="group relative h-48 rounded-2xl bg-slate-200 overflow-hidden border border-slate-200 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent z-10"></div>
                    <div class="absolute bottom-3 left-3 right-3 z-20">
                        <span class="text-[10px] font-bold text-blue-400 uppercase tracking-wider block">{{ $gal->category }}</span>
                        <h4 class="text-xs font-bold text-white truncate">{{ $gal->title }}</h4>
                        <p class="text-[10px] text-slate-300">{{ $gal->items->count() }} Foto dalam album</p>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-8 text-xs text-slate-400 border border-dashed border-slate-200 rounded-2xl">
                    Belum ada dokumentasi galeri publik.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 6. KARYA & PROJECT PILIHAN -->
<section id="projects" class="py-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Portfolio</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Karya & Project Unggulan Siswa</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse ($featuredProjects as $proj)
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 flex flex-col justify-between space-y-4">
                    <div>
                        <span class="px-3 py-1 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase mb-3 inline-block">Project Showcase</span>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $proj->title }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">{{ $proj->description }}</p>
                    </div>
                    <div class="pt-4 border-t border-slate-200 text-xs font-medium text-slate-500 flex justify-between items-center">
                        <span>Tim: {{ $proj->members->count() }} Anggota</span>
                        <a href="#" class="text-blue-600 font-bold hover:underline">Detail Project →</a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-xs text-slate-400 border border-dashed border-slate-200 rounded-2xl">
                    Belum ada karya project yang dipublikasikan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 7. APRESIASI / HIGHLIGHT PRESTASI -->
<section class="py-16 bg-slate-50 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Prestasi</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Apresiasi & Highlight Pencapaian</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            @forelse ($appreciations as $app)
                <div class="bg-white p-6 rounded-2xl border border-slate-200 flex items-center space-x-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-extrabold text-xl flex-shrink-0">
                        🏆
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $app->title }}</h4>
                        <p class="text-xs text-slate-500">{{ $app->description }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-xs text-slate-400 border border-dashed border-slate-200 rounded-2xl">
                    Belum ada apresiasi publik yang dicatat.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 8. ANGGOTA (Preview Siswa) -->
<section class="py-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Struktur</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Anggota XI PPLG 2</h2>
            </div>
            <a href="{{ route('public.about') }}#members" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua Siswa →</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @forelse ($members as $mb)
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center">
                    <div class="w-14 h-14 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center mx-auto mb-3 text-base uppercase">
                        {{ substr($mb->name, 0, 2) }}
                    </div>
                    <h4 class="font-bold text-xs text-slate-900 truncate">{{ $mb->name }}</h4>
                    <p class="text-[10px] text-slate-400">XI PPLG 2</p>
                </div>
            @empty
                <div class="col-span-6 text-center py-8 text-xs text-slate-400">Data siswa publik belum tersedia.</div>
            @endforelse
        </div>
    </div>
</section>



@endsection