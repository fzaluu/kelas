<footer class="bg-slate-950 text-slate-300 pt-16 pb-8 border-t border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- 1. IDENTITAS UTAMA -->
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-12">
            <!-- Icon / Logo Kelas -->
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-700 to-blue-500 text-white font-black text-2xl flex items-center justify-center mx-auto shadow-lg shadow-blue-500/20">
                P2
            </div>
            
            <!-- Judul & Sekolah -->
            <div>
                <h3 class="text-xl font-extrabold text-white tracking-tight uppercase">Website Kelas PPLG</h3>
                <p class="text-xs font-semibold text-blue-400 tracking-wider uppercase mt-0.5">SMKN 4 Kota Tasikmalaya</p>
            </div>

            <!-- Deskripsi -->
            <p class="text-xs text-slate-400 leading-relaxed pt-1 max-w-lg mx-auto">
                Wadah resmi transparansi akademik, pusat presensi digital harian, dokumentasi karya perangkat lunak, serta portofolio kegiatan siswa XI PPLG 2.
            </p>
        </div>

        <hr class="border-slate-800/60 my-8">

        <!-- 2. NAVIGASI UTAMA + 3. TERHUBUNG -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-center md:text-left mb-10">
            <!-- Navigasi Utama (Direct Routes) -->
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Navigasi Utama</h4>
                <ul class="flex flex-wrap justify-center md:justify-start gap-x-6 gap-y-2 text-xs font-medium">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="{{ route('public.about') }}" class="hover:text-blue-400 transition">Tentang</a></li>
                    <li><a href="{{ route('public.information.announcements') }}" class="hover:text-blue-400 transition">Informasi</a></li>
                    <li><a href="{{ route('public.gallery.activities') }}" class="hover:text-blue-400 transition">Galeri</a></li>
                    <li><a href="{{ route('public.contact') }}" class="hover:text-blue-400 transition">Kontak</a></li>
                </ul>
            </div>

            <!-- Terhubung (Media Sosial) -->
            <div class="md:text-right">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Terhubung</h4>
                <ul class="flex flex-wrap justify-center md:justify-end gap-x-6 gap-y-2 text-xs font-medium">
                    <li>
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="hover:text-blue-400 transition inline-flex items-center space-x-1">
                            <span>Instagram</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://tiktok.com" target="_blank" rel="noopener" class="hover:text-blue-400 transition inline-flex items-center space-x-1">
                            <span>TikTok</span>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:info@smkn4tasikmalaya.sch.id" class="hover:text-blue-400 transition inline-flex items-center space-x-1">
                            <span>Email Official</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-slate-800/60 my-8">

        <!-- 4. IDENTITAS INSTITUSI (Logo PPLG + Logo SMKN 4) -->
        <div class="flex justify-center items-center space-x-4 mb-8">
            <div class="flex items-center space-x-2 bg-slate-900 px-3.5 py-1.5 rounded-xl border border-slate-800">
                <div class="w-5 h-5 rounded bg-blue-600 text-white font-bold text-[10px] flex items-center justify-center">
                    P
                </div>
                <span class="text-[11px] font-bold text-slate-300">PPLG</span>
            </div>

            <span class="text-slate-700 text-xs">•</span>

            <div class="flex items-center space-x-2 bg-slate-900 px-3.5 py-1.5 rounded-xl border border-slate-800">
                <div class="w-5 h-5 rounded bg-amber-600 text-white font-bold text-[10px] flex items-center justify-center">
                    4
                </div>
                <span class="text-[11px] font-bold text-slate-300">SMKN 4 Tasikmalaya</span>
            </div>
        </div>

        <!-- 5. FOOTER BOTTOM -->
        <div class="flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500 gap-y-3 pt-6 border-t border-slate-900">
            <div>
                &copy; 2026 Website Kelas PPLG — SMKN 4 Kota Tasikmalaya
            </div>

            <!-- Tombol Kembali ke Atas -->
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="hover:text-slate-200 hover:border-slate-600 transition flex items-center space-x-1.5 bg-slate-900 px-3 py-1.5 rounded-lg border border-slate-800 text-slate-400">
                <span>Kembali ke atas</span>
                <span>↑</span>
            </button>
        </div>

    </div>
</footer>