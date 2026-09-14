<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Presensi Siswa - Matriks</title>
    <style>
        body { font-family: sans-serif; padding: 20px; color: #1e293b; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; font-size: 13px; }
        th, td { border: 1px solid #64748b; padding: 6px 8px; text-align: center; }
        th { background-color: #ffedd5; }
        .text-left { text-align: left; }
        .badge-h { background: #dcfce7; color: #166534; font-weight: bold; }
        .badge-s { background: #fef9c3; color: #854d0e; font-weight: bold; }
        .badge-i { background: #e0f2fe; color: #075985; font-weight: bold; }
        .badge-a { background: #fee2e2; color: #991b1b; font-weight: bold; }
    </style>
</head>
<body>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Buku Rekapituasi Presensi Siswa</h2>
        <a href="{{ route('teacher.attendance.index') }}" style="background: #475569; color: #fff; padding: 8px 12px; border-radius: 4px; text-decoration: none;">← Kembali ke Kelola QR</a>
    </div>

    @if (session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Input Manual & Filter Sesi -->
    <div style="background: #f8fafc; padding: 15px; border-radius: 6px; border: 1px solid #cbd5e1; margin-bottom: 20px;">
        <form action="{{ route('teacher.attendance.recap') }}" method="GET" style="display: inline-block; margin-right: 30px;">
            <label><strong>Pilih Sesi/Pertemuan:</strong></label>
            <select name="session_id" onchange="this.form.submit()" style="padding: 6px 10px;">
                @foreach ($sessions as $index => $sess)
                    <option value="{{ $sess->id }}" {{ $sess->id == $selectedSessionId ? 'selected' : '' }}>
                        Pertemuan {{ $index + 1 }} ({{ \Carbon\Carbon::parse($sess->attendance_date)->format('d/m/Y') }} - {{ $sess->title }})
                    </option>
                @endforeach
            </select>
        </form>

        @if ($selectedSession)
        <form action="{{ route('teacher.attendance.manual') }}" method="POST" style="display: inline-block;">
            @csrf
            <input type="hidden" name="session_id" value="{{ $selectedSession->id }}">
            <label><strong>Input Manual Presensi:</strong></label>
            <select name="member_id" required style="padding: 6px;">
                <option value="">-- Pilih Siswa --</option>
                @foreach ($members as $mb)
                    <option value="{{ $mb->id }}">{{ $mb->name }}</option>
                @endforeach
            </select>

            <select name="status" required style="padding: 6px;">
                <option value="HADIR">HADIR (H)</option>
                <option value="SAKIT">SAKIT (S)</option>
                <option value="IZIN">IZIN (I)</option>
                <option value="ALPA">ALPA (A)</option>
            </select>

            <button type="submit" style="background: #16a34a; color: #fff; border: 0; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold;">Update Status</button>
        </form>
        @endif
    </div>

    <!-- Tabel Matriks Presensi (Sesuai Foto Format Fisik) -->
    <table>
        <thead>
            <tr>
                <th rowspan="3" style="width: 40px;">NO</th>
                <th colspan="{{ max(count($sessions), 1) }}">PERTEMUAN KE</th>
                <th colspan="3" rowspan="2">Jumlah Absensi</th>
            </tr>
            <tr>
                @foreach ($sessions as $index => $sess)
                    <th>{{ $index + 1 }}</th>
                @endforeach
            </tr>
            <tr>
                <th class="text-left">NAMA SISWA</th>
                @foreach ($sessions as $sess)
                    <th style="font-size: 10px;">{{ \Carbon\Carbon::parse($sess->attendance_date)->format('d/m') }}</th>
                @endforeach
                <th style="width: 30px; background: #fef9c3;">S</th>
                <th style="width: 30px; background: #e0f2fe;">I</th>
                <th style="width: 30px; background: #fee2e2;">A</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $no => $member)
                @php
                    $countS = 0;
                    $countI = 0;
                    $countA = 0;
                @endphp
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td class="text-left"><strong>{{ strtoupper($member->name) }}</strong></td>
                    
                    @foreach ($sessions as $sess)
                        @php
                            $rec = $records[$member->id][$sess->id]->first() ?? null;
                            $st = $rec->status ?? '-';

                            if ($st === 'SAKIT') $countS++;
                            if ($st === 'IZIN') $countI++;
                            if ($st === 'ALPA') $countA++;
                        @endphp

                        <td class="{{ $st == 'HADIR' || $st == 'TERLAMBAT' ? 'badge-h' : ($st == 'SAKIT' ? 'badge-s' : ($st == 'IZIN' ? 'badge-i' : ($st == 'ALPA' ? 'badge-a' : ''))) }}">
                            @if($st == 'HADIR' || $st == 'TERLAMBAT') H
                            @elseif($st == 'SAKIT') S
                            @elseif($st == 'IZIN') I
                            @elseif($st == 'ALPA') A
                            @else -
                            @endif
                        </td>
                    @endforeach

                    <td style="background: #fef9c3;">{{ $countS }}</td>
                    <td style="background: #e0f2fe;">{{ $countI }}</td>
                    <td style="background: #fee2e2;">{{ $countA }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($sessions) + 5 }}">Belum ada data siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>