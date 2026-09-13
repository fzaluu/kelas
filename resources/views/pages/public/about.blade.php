@extends('layouts.public')

@section('title', 'Tentang Kelas')

@section('content')
<div style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
    <div style="background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1>Tentang Kelas {{ $class->name ?? 'PPLG 2' }}</h1>
        <p>Halaman ini berisi struktur organisasi, profil kelas, dan daftar anggota kelas resmi.</p>
    </div>
</div>
@endsection