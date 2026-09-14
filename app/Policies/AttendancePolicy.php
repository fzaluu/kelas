<?php

namespace App\Policies;

use App\Models\Core\User;
use App\Models\Attendance\AttendanceSession;

class AttendancePolicy
{
    /**
     * Otorisasi Scan Absensi: Siswa hanya bisa scan jika kelasnya cocok dengan sesi absensi
     */
    public function scan(User $user, AttendanceSession $session): bool
    {
        // 1. User wajib terikat dengan Member aktif
        if (!$user->member || $user->member->member_status !== 'ACTIVE') {
            return false;
        }

        // 2. Class Scoping: Siswa kelas X tidak boleh scan di Sesi Absensi kelas Y
        return (int) $user->member->class_id === (int) $session->class_id;
    }

    /**
     * Otorisasi Kelola Sesi Absensi: Wali Kelas / Pengurus hanya bisa mengelola sesi kelasnya sendiri
     */
    public function manage(User $user, int $targetClassId): bool
    {
        if ($user->hasRole('development')) {
            return true; // Dev akses platform
        }

        if ($user->member) {
            return (int) $user->member->class_id === (int) $targetClassId;
        }

        return false;
    }
}