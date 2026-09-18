<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $pendingUsers = User::with('classMember')
            ->where('approval_status', 'PENDING')
            ->latest()
            ->get();

        return view('pages.development.approvals.index', compact('pendingUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['approval_status' => 'APPROVED']);

        return redirect()->route('development.approvals.index')
            ->with('success', "Akun {$user->name} berhasil disetujui! Siswa kini dapat login.");
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['approval_status' => 'REJECTED']);

        return redirect()->route('development.approvals.index')
            ->with('error', "Pendaftaran akun {$user->name} telah ditolak.");
    }
}