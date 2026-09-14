<?php

namespace App\Services;

use App\Models\Attendance\AttendanceSession;
use App\Models\Attendance\AttendanceRecord;
use App\Models\Core\Member;
use App\Models\Core\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AttendanceQRService
{
    /**
     * Generate Kode Token Ramah Manusia (6 Karakter Kapital Acak tanpa karakter membingungkan)
     */
    protected function generateHumanFriendlyToken(int $length = 6): string
    {
        // Karakter yang aman diketik (tanpa 0, O, 1, I, L)
        $characters = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';
        $token = '';
        $maxIndex = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[random_int(0, $maxIndex)];
        }

        return $token;
    }

    /**
     * Membuka Sesi Absensi Baru & Melakukan Inisialisasi Record ALPA untuk Seluruh Siswa Kelas
     */
    public function createSession(int $classId, string $title, int $durationMinutes, int $creatorUserId): AttendanceSession
    {
        // Tutup sesi lama yang masih OPEN di kelas tersebut
        AttendanceSession::where('class_id', $classId)
            ->where('status', 'OPEN')
            ->update(['status' => 'CLOSED']);

        $now = Carbon::now('Asia/Jakarta');
        
        // Generate token 6 digit yang mudah diketik
        $rawToken = $this->generateHumanFriendlyToken(6);

        $session = AttendanceSession::create([
            'class_id' => $classId,
            'title' => $title,
            'attendance_date' => $now->toDateString(),
            'start_at' => $now,
            'end_at' => $now->copy()->addMinutes($durationMinutes),
            'status' => 'OPEN',
            'token_hash' => Hash::make($rawToken),
            'created_by' => $creatorUserId,
        ]);

        // Inisialisasi record default ALPA untuk seluruh member di kelas tersebut
        $members = Member::where('class_id', $classId)
            ->where('member_status', 'ACTIVE')
            ->get();

        foreach ($members as $member) {
            AttendanceRecord::create([
                'attendance_session_id' => $session->id,
                'member_id' => $member->id,
                'status' => 'ALPA',
                'method' => 'QR',
            ]);
        }

        // Catat Audit Log
        ActivityLog::create([
            'actor_user_id' => $creatorUserId,
            'action' => 'attendance.session.create',
            'resource_type' => 'attendance_session',
            'resource_id' => $session->id,
            'result' => 'SUCCESS',
        ]);

        // Simpan raw token secara temporer di instance agar bisa ditampilkan sebagai QR & fallback text di view
        $session->raw_token = $rawToken;

        return $session;
    }

    /**
     * Validasi Scan QR Siswa & Update Attendance Record
     */
    public function scanQR(int $sessionId, string $scannedToken, int $authUserId, ?string $ip = null, ?string $userAgent = null): array
    {
        $session = AttendanceSession::find($sessionId);

        if (!$session || $session->status !== 'OPEN') {
            return ['success' => false, 'message' => 'Sesi absensi tidak ditemukan atau sudah ditutup.'];
        }

        $now = Carbon::now('Asia/Jakarta');
        if ($now->greaterThan($session->end_at)) {
            $session->update(['status' => 'CLOSED', 'closed_at' => $now]);
            return ['success' => false, 'message' => 'Waktu absensi telah berakhir. Sesi ditutup otomatis.'];
        }

        // Validasi match token hash (Mendukung input uppercase)
        if (!Hash::check(strtoupper(trim($scannedToken)), $session->token_hash)) {
            ActivityLog::create([
                'actor_user_id' => $authUserId,
                'action' => 'attendance.scan',
                'resource_type' => 'attendance_session',
                'resource_id' => $sessionId,
                'result' => 'FAILED',
                'ip' => $ip,
                'user_agent' => $userAgent,
            ]);

            return ['success' => false, 'message' => 'Token QR / Kode manual tidak valid atau sudah kadaluarsa.'];
        }

        // Ambil identitas member berdasarkan user yang login (Security Rule: Identitas bukan dari QR)
        $member = Member::where('id', function ($query) use ($authUserId) {
            $query->select('member_id')->from('users')->where('id', $authUserId);
        })->first();

        if (!$member) {
            return ['success' => false, 'message' => 'Akun Anda tidak terhubung dengan data anggota siswa mana pun.'];
        }

        // Validasi Class Scope: Siswa harus berada di kelas yang sama dengan sesi absensi
        if ((int) $member->class_id !== (int) $session->class_id) {
            return ['success' => false, 'message' => 'Anda tidak terdaftar di kelas sesi absensi ini.'];
        }

        $record = AttendanceRecord::where('attendance_session_id', $sessionId)
            ->where('member_id', $member->id)
            ->first();

        if (!$record) {
            return ['success' => false, 'message' => 'Data absensi Anda tidak terdaftar pada sesi ini.'];
        }

        if (in_array($record->status, ['HADIR', 'TERLAMBAT'])) {
            return ['success' => false, 'message' => 'Anda sudah melakukan absensi pada sesi ini.'];
        }

        // Tentukan status kehadiran (Hadir vs Terlambat)
        // Toleransi keterlambatan: 15 menit setelah sesi dibuat
        $lateThreshold = $session->start_at->copy()->addMinutes(15);
        $newStatus = $now->greaterThan($lateThreshold) ? 'TERLAMBAT' : 'HADIR';

        $record->update([
            'status' => $newStatus,
            'check_in_at' => $now,
            'method' => 'QR',
            'recorded_by' => $authUserId,
        ]);

        // Audit Trail
        ActivityLog::create([
            'actor_user_id' => $authUserId,
            'action' => 'attendance.scan',
            'resource_type' => 'attendance_record',
            'resource_id' => $record->id,
            'result' => 'SUCCESS',
            'ip' => $ip,
            'user_agent' => $userAgent,
        ]);

        return [
            'success' => true,
            'message' => 'Absensi berhasil dicatat! Status: ' . $newStatus,
            'status' => $newStatus,
            'check_in_at' => $now->format('H:i:s WIB'),
        ];
    }
}