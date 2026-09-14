<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Absensi - Wali Kelas</title>
</head>
<body style="font-family: sans-serif; max-width: 800px; margin: 30px auto; padding: 20px; color: #1e293b;">

    <!-- Header & Navigation Button ke Recap -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="margin: 0;">Kelola Sesi Absensi QR Kelas</h2>
        <a href="{{ route('teacher.attendance.recap') }}" style="background: #0d9488; color: #ffffff; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            📊 Lihat Buku Rekapitulasi Presensi →
        </a>
    </div>

    @if (session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tampilan Sesi Aktif & QR Code Dinamis -->
    @if ($activeSession)
        <div style="background: #eff6ff; padding: 20px; border-radius: 8px; border: 2px dashed #2563eb; text-align: center; margin-bottom: 30px;">
            <h3 style="margin-top: 0; color: #1e40af;">SESI AKTIF: {{ $activeSession->title }}</h3>

            @if ($activeToken)
                <p>Scan QR di bawah ini menggunakan kamera HP Siswa:</p>
                <div style="background: #fff; display: inline-block; padding: 15px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(220)->generate($activeToken) !!}
                </div>

                <p style="margin-top: 15px; font-size: 14px; color: #4b5563;">
                    Kode Token Manual Fallback: <strong style="background: #fef08a; padding: 4px 8px; border-radius: 4px; font-family: monospace;">{{ $activeToken }}</strong>
                </p>
            @endif

            <p style="font-size: 12px; color: #6b7280;">Berakhir pada: {{ $activeSession->end_at->format('H:i:s WIB') }}</p>

            <!-- Tombol Tutup Sesi Manual -->
            <form action="{{ route('teacher.attendance.close', $activeSession->id) }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menutup sesi absensi ini sekarang?')" style="background: #dc2626; color: #fff; border: 0; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                    🛑 Tutup Sesi Absensi Sekarang
                </button>
            </form>
        </div>
    @endif

    <div style="background: #f1f5f9; padding: 20px; border-radius: 6px; margin-bottom: 30px;">
        <h3>Buka Sesi Absensi Baru</h3>
        <form action="{{ route('teacher.attendance.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 10px;">
                <label>Judul Sesi Absensi:</label><br>
                <input type="text" name="title" value="Absensi Harian PPLG 2" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Durasi (Menit):</label><br>
                <input type="number" name="duration_minutes" value="30" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <button type="submit" style="background: #2563eb; color: #fff; border: 0; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">Buka Sesi QR Baru</button>
        </form>
    </div>

    <h3>Daftar Histori Sesi Absensi</h3>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr style="background: #e2e8f0;">
                <th>ID</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Berakhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sessions as $session)
                <tr>
                    <td>{{ $session->id }}</td>
                    <td>{{ $session->title }}</td>
                    <td>{{ $session->attendance_date }}</td>
                    <td><strong>{{ $session->status }}</strong></td>
                    <td>{{ $session->end_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada sesi absensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>