<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\AccountRegistration;
use App\Models\Core\Member;
use App\Models\Core\User;
use App\Models\Core\Role;
use App\Models\Core\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index()
    {
        // Ambil pendaftaran mandiri yang berstatus PENDING
        $pendingRegistrations = AccountRegistration::where('status', 'PENDING')
            ->latest()
            ->paginate(15);

        return view('pages.development.approvals.index', compact('pendingRegistrations'));
    }

    public function approve($id)
    {
        $registration = AccountRegistration::findOrFail($id);

        if ($registration->status !== 'PENDING') {
            return redirect()->back()->with('error', 'Pendaftaran ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($registration) {
            // 1. Dapatkan ID Kelas Aktif
            $activeClass = SchoolClass::first();
            $classId = $activeClass ? $activeClass->id : 1;

            // 2. Buat Record Member (Single Source of Truth)
            $member = Member::create([
                'class_id'      => $classId,
                'nis'           => $registration->nis,
                'nisn'          => $registration->nisn,
                'name'          => $registration->full_name,
                'gender'        => $registration->gender,
                'member_status' => 'ACTIVE',
                'joined_at'     => now(),
            ]);

            // 3. Buat Record User
            $user = User::create([
                'member_id' => $member->id,
                'username'  => $registration->username,
                'email'     => $registration->email,
                'password'  => $registration->password, // Sudah berupa hash dari registration
                'status'    => 'ACTIVE',
            ]);

            // 4. Attach Role 'student' (atau 'siswa')
            $studentRole = Role::where('slug', 'student')
                ->orWhere('name', 'student')
                ->orWhere('slug', 'siswa')
                ->first();

            if ($studentRole) {
                $user->roles()->attach($studentRole->id, [
                    'assigned_at' => now(),
                    'assigned_by' => auth()->id(),
                ]);
            }

            // 5. Update Status Registrasi
            $registration->update([
                'status'      => 'APPROVED',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        });

        return redirect()->route('development.approvals.index')
            ->with('success', "Pendaftaran {$registration->full_name} berhasil disetujui dan akun siswa telah aktif!");
    }

    public function reject(Request $request, $id)
    {
        $registration = AccountRegistration::findOrFail($id);

        $registration->update([
            'status'           => 'REJECTED',
            'rejection_reason' => $request->input('rejection_reason', 'Pendaftaran ditolak oleh administrator.'),
            'reviewed_by'      => auth()->id(),
            'reviewed_at'      => now(),
        ]);

        return redirect()->route('development.approvals.index')
            ->with('success', "Pendaftaran {$registration->full_name} telah ditolak.");
    }
}