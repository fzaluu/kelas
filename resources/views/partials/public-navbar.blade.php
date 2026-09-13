<nav style="background: #1e293b; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center;">
    <div style="font-weight: bold; font-size: 1.2rem;">
        <a href="{{ route('home') }}" style="color: #fff; text-decoration: none;">Website Kelas PPLG 2</a>
    </div>
    <ul style="list-style: none; display: flex; gap: 20px; margin: 0; padding: 0;">
        <li><a href="{{ route('home') }}" style="color: #fff; text-decoration: none;">🏠 Beranda</a></li>
        <li><a href="{{ route('public.about') }}" style="color: #fff; text-decoration: none;">📖 Tentang</a></li>
        <li><a href="#" style="color: #aaa; text-decoration: none;">📢 Informasi</a></li>
        <li><a href="#" style="color: #aaa; text-decoration: none;">🖼️ Galeri</a></li>
        <li><a href="#" style="color: #aaa; text-decoration: none;">📞 Kontak</a></li>
    </ul>
    <div>
        @auth
            <a href="{{ route('development.dashboard') }}" style="background: #3b82f6; color: #fff; padding: 8px 15px; text-decoration: none; border-radius: 4px;">Member Area</a>
        @else
            <a href="{{ route('login') }}" style="background: #10b981; color: #fff; padding: 8px 15px; text-decoration: none; border-radius: 4px;">Login</a>
        @endauth
    </div>
</nav>