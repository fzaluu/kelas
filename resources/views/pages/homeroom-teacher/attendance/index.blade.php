<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Absensi - Wali Kelas</title>
</head>
<body style="font-family: sans-serif; max-width: 800px; margin: 30px auto; padding: 20px;">
    <h2>Kelola Sesi Absensi QR Kelas</h2>

    @if (session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #f1f5f9; padding: 20px; border-radius: 6px; margin-bottom: 30px;">
        <h3>Buka Sesi Absensi Baru</h3>
        <form action="{{ route('teacher.attendance.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 10px;">
                <label>Judul Sesi Absensi:</label><br>
                <input type="text" name="title" value="Absensi Harian PPLG 2" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Durasi (Menit):</label><br>
                <input type="number" name="duration_minutes" value="30" required style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" style="background: #2563eb; color: #fff; border: 0; padding: 10px 15px; border-radius: 4px; cursor: pointer;">Buka Sesi QR</button>
        </form>
    </div>

    <h3>Daftar Sesi Absensi</h3>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr style="background: #e2e8f0;">
                <th>ID</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Waktu Berakhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sessions as $session)
                <tr>
                    <td>{{ $session->id }}</td>
                    <td>{{ $session->title }}</td>
                    <td>{{ $session->attendance_date }}</td>
                    <td><strong>{{ $session->status }}</strong></td>
                    <td>{{ $session->end_at->format('H:i:s WIB') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada sesi absensi yang dibuat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>