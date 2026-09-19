<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\Core\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApprovalController extends Controller
{
    public function index()
    {
        // Hanya ambil pendaftaran mandiri yang kedua kolom statusnya bernilai PENDING
        $pendingUsers = User::query()
            ->where(function ($q) {
                if (Schema::hasColumn('users', 'approval_status')) {
                    $q->where('approval_status', 'PENDING');
                }
            })
            ->where(function ($q) {
                if (Schema::hasColumn('users', 'status')) {
                    $q->where('status', 'PENDING');
                }
            })
            ->latest()
            ->paginate(15);

        return view('pages.development.approvals.index', compact('pendingUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        DB::transaction(function () use ($user) {
            $memberId = $user->member_id;

            if (!$memberId) {
                $memberData = [
                    'class_id' => 1,
                    'name'     => $user->name ?? $user->username,
                ];

                if (Schema::hasColumn('members', 'gender')) {
                    $memberData['gender'] = 'L';
                }

                if (Schema::hasColumn('members', 'member_status')) {
                    $memberData['member_status'] = 'ACTIVE';
                } elseif (Schema::hasColumn('members', 'status')) {
                    $memberData['status'] = 'ACTIVE';
                }

                $member = Member::create($memberData);
                $memberId = $member->id;
            }

            $updateData = [];

            if (Schema::hasColumn('users', 'approval_status')) {
                $updateData['approval_status'] = 'APPROVED';
            }

            if (Schema::hasColumn('users', 'status')) {
                $updateData['status'] = 'ACTIVE';
            }

            if (Schema::hasColumn('users', 'member_id')) {
                $updateData['member_id'] = $memberId;
            }

            $updateData['updated_at'] = now();

            DB::table('users')->where('id', $user->id)->update($updateData);
        });

        return redirect()->route('development.approvals.index')
            ->with('success', 'Akun pengguna berhasil disetujui!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);

        $updateData = [];
        if (Schema::hasColumn('users', 'approval_status')) {
            $updateData['approval_status'] = 'REJECTED';
        }

        if (Schema::hasColumn('users', 'status')) {
            $updateData['status'] = 'INACTIVE';
        }

        $updateData['updated_at'] = now();

        DB::table('users')->where('id', $user->id)->update($updateData);

        return redirect()->route('development.approvals.index')
            ->with('success', 'Pendaftaran akun telah ditolak.');
    }
}