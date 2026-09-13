@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<div style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
    <div style="background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="color: #1e293b; margin-top: 0;">Selamat Datang di Portal Resmi Kelas {{ $class->name ?? 'PPLG' }}</h1>
        <p style="font-size: 1.1rem; color: #64748b;">
            Pusat informasi, dokumentasi kegiatan, portofolio karya, dan aktivitas pembelajaran siswa PPLG SMKN 4 Kota Tasikmalaya.
        </p>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">

        <h3>Quick Information</h3>
        <ul>
            <li><strong>Jurusan:</strong> {{ $class->major ?? 'Pengembangan Perangkat Lunak dan Gim' }}</li>
            <li><strong>Tahun Ajaran:</strong> {{ $class->academic_year ?? '2025/2026' }}</li>
            <li><strong>Status Sistem:</strong> Active & Synchronized</li>
        </ul>
    </div>
</div>
@endsection