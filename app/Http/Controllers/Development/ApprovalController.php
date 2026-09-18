<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\Core\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('approval_status', 'PENDING')->latest()->paginate(15);
        return view('pages.development.approvals.index', compact('pendingUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        DB::transaction(function () use ($user) {
            // Buat data member siswa otomatis
            $member = Member::create([
                'class_id'      => 1, // Default ID Kelas XI PPLG 2
                'name'          => $user->username,
                'gender'        => 'L',
                'member_status' => 'ACTIVE',
            ]);

            // Hubungkan user ke member dan aktifkan akun
            $user->update([
                'member_id'       => $member->id,
                'status'          => 'ACTIVE',
                'approval_status' => 'APPROVED',
            ]);
        });

        return redirect()->route('development.approvals.index')
            ->with('success', 'Akun pengguna berhasil disetujui!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        
        $user->update([
            'status'          => 'INACTIVE',
            'approval_status' => 'REJECTED',
        ]);

        return redirect()->route('development.approvals.index')
            ->with('success', 'Pendaftaran akun telah ditolak.');
    }
}