<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Sesi Absensi #{{ $session->id }}</title>
</head>
<body style="font-family: sans-serif; padding: 30px;">
    <h2>Detail Sesi: {{ $session->title }}</h2>
    <p>Status: <strong>{{ $session->status }}</strong> | Tanggal: {{ $session->attendance_date }}</p>
    
    <a href="{{ route('teacher.attendance.index') }}">&larr; Kembali ke Daftar Sesi</a>

    <h3 style="margin-top: 30px;">Rekap Kehadiran Siswa</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #e2e8f0;">
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Status Kehadiran</th>
                <th>Waktu Scan</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @forelse($session->records as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->member->name ?? 'Siswa #'.$r->member_id }}</td>
                    <td>
                        @if($r->status == 'HADIR') <span style="color: green; font-weight: bold;">HADIR</span>
                        @elseif($r->status == 'TERLAMBAT') <span style="color: orange; font-weight: bold;">TERLAMBAT</span>
                        @else <span style="color: red; font-weight: bold;">{{ $r->status }}</span>
                        @endif
                    </td>
                    <td>{{ $r->check_in_at ? $r->check_in_at->format('H:i:s WIB') : '-' }}</td>
                    <td>{{ $r->method }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada record absensi.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>