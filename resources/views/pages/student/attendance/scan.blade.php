<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Scan Absensi QR Siswa</title>
</head>
<body style="font-family: sans-serif; max-width: 500px; margin: 30px auto; padding: 20px;">
    <h2>Scan Absensi QR Siswa</h2>

    @if (session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->has('scan'))
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            {{ $errors->first('scan') }}
        </div>
    @endif

    @if ($activeSession)
        <div style="background: #eff6ff; padding: 20px; border-radius: 6px; border: 1px solid #bfdbfe;">
            <h3 style="margin-top: 0; color: #1e40af;">Sesi Aktif: {{ $activeSession->title }}</h3>
            <p>Waktu Berakhir: <strong>{{ $activeSession->end_at->format('H:i:s WIB') }}</strong></p>

            <form action="{{ route('student.attendance.scan.post') }}" method="POST">
                @csrf
                <input type="hidden" name="session_id" value="{{ $activeSession->id }}">
                
                <div style="margin-bottom: 15px;">
                    <label>Masukkan Kode Token QR:</label><br>
                    <input type="text" name="scanned_token" placeholder="Tempelkan token QR di sini" required style="width: 100%; padding: 10px; margin-top: 5px;">
                </div>

                <button type="submit" style="background: #16a34a; color: #fff; border: 0; padding: 10px 15px; width: 100%; border-radius: 4px; font-weight: bold; cursor: pointer;">Kirim Absensi</button>
            </form>
        </div>
    @else
        <div style="background: #f3f4f6; padding: 20px; text-align: center; border-radius: 6px;">
            <p style="color: #4b5563;">Saat ini tidak ada sesi absensi yang sedang dibuka oleh guru.</p>
        </div>
    @endif
</body>
</html>