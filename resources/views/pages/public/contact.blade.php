@extends('layouts.public')

@section('title', 'Kontak Resmi - XI PPLG 2')

@section('content')

<!-- 1. HEADER PAGE -->
<section class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 py-16 border-b border-slate-100 text-center">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700 uppercase tracking-wider inline-block mb-3">
            Hubungi Kami
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            Terhubung Dengan Kelas XI PPLG 2
        </h1>
        <p class="mt-4 text-sm sm:text-base text-slate-600 max-w-xl mx-auto">
            Ada yang ingin ditanyakan atau ingin berkolaborasi? Semua jalur komunikasi resmi kami tersedia dalam satu halaman.
        </p>
    </div>
</section>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- 2. MEDIA SOSIAL RESMI -->
    <div>
        <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Platform Digital</h3>
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Media Sosial Resmi Kelas</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <a href="https://instagram.com" target="_blank" rel="noopener" class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition group flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 font-bold text-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    📸
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-blue-600 transition">Instagram</h4>
                    <p class="text-xs text-slate-500">@pplg2.smkn4tsm</p>
                </div>
            </a>

            <a href="https://tiktok.com" target="_blank" rel="noopener" class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition group flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-800 font-bold text-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    🎵
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-blue-600 transition">TikTok</h4>
                    <p class="text-xs text-slate-500">@pplg2_official</p>
                </div>
            </a>

            <a href="https://github.com" target="_blank" rel="noopener" class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition group flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 font-bold text-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    💻
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-blue-600 transition">GitHub Organization</h4>
                    <p class="text-xs text-slate-500">XI-PPLG2-Repository</p>
                </div>
            </a>
        </div>
    </div>

    <!-- 3. KONTAK RESMI & 4. LOKASI SEKOLAH -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Kontak Resmi -->
        <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200 space-y-4">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Informasi Publik</span>
            <h3 class="text-xl font-bold text-slate-900">Kontak Pengurus Kelas</h3>
            
            <div class="space-y-3 pt-2">
                <div class="flex items-start space-x-3 text-xs sm:text-sm">
                    <span class="text-slate-400 font-bold">Email:</span>
                    <span class="text-slate-800 font-semibold">pplg2@smkn4tasikmalaya.sch.id</span>
                </div>
                <div class="flex items-start space-x-3 text-xs sm:text-sm">
                    <span class="text-slate-400 font-bold">Wali Kelas:</span>
                    <span class="text-slate-800 font-semibold">Portal Resmi Wali Kelas XI PPLG 2</span>
                </div>
                <div class="flex items-start space-x-3 text-xs sm:text-sm">
                    <span class="text-slate-400 font-bold">Sekolah:</span>
                    <span class="text-slate-800 font-semibold">SMKN 4 Kota Tasikmalaya</span>
                </div>
            </div>
        </div>

        <!-- Lokasi Sekolah -->
        <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200 space-y-4">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Lokasi Pembelajaran</span>
            <h3 class="text-xl font-bold text-slate-900">Alamat Sekolah</h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                SMKN 4 Kota Tasikmalaya<br>
                Jl. Depok, Sukamenak, Purbaratu, Kota Tasikmalaya, Jawa Barat 46196.
            </p>
            <div class="pt-2">
                <span class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-semibold text-slate-700 inline-block">
                    📍 Gedung Bengkel PPLG / Lab Komputer
                </span>
            </div>
        </div>

    </div>

    <!-- 5. HUBUNGI KAMI / FEEDBACK FORM -->
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-sm">
        <div class="max-w-2xl">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Formulir Pesan</span>
            <h3 class="text-2xl font-bold text-slate-900 mt-1 mb-2">Kirim Pesan Atau Masukan</h3>
            <p class="text-xs sm:text-sm text-slate-500 mb-8">
                Punya pertanyaan, kritik, atau ide kerja sama? Isi formulir di bawah ini dan pengurus kelas akan merespons secepatnya.
            </p>
        </div>

        <form action="{{ route('public.contact.submit') }}" method="POST" class="space-y-6 max-w-2xl">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Masukkan nama Anda" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                    <input type="email" name="email" required placeholder="nama@email.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pesan / Masukan</label>
                <textarea name="message" rows="4" required placeholder="Tuliskan pesan Anda di sini..." class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition"></textarea>
            </div>

            <button type="submit" class="px-6 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-500/20 transition hover:scale-105 active:scale-95">
                Kirim Pesan Sekarang →
            </button>
        </form>
    </div>

</div>

@endsection