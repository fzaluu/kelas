<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    private function getModelClass(string $name, string $subfolder = '')
    {
        $namespacedWithFolder = "App\\Models\\{$subfolder}\\{$name}";
        if (class_exists($namespacedWithFolder)) {
            return $namespacedWithFolder;
        }

        $namespacedDirect = "App\\Models\\{$name}";
        if (class_exists($namespacedDirect)) {
            return $namespacedDirect;
        }

        return null;
    }

    public function profile()
    {
        $classId = SchoolClass::getActiveId();

        $ClassProfileModel  = $this->getModelClass('ClassProfile', 'Core');
        $ClassPositionModel = $this->getModelClass('ClassPosition', 'Core');
        $MemberModel        = $this->getModelClass('Member', 'Core');

        // 1. Profil & Identitas Kelas
        $profile = $ClassProfileModel ? $ClassProfileModel::where('class_id', $classId)->first() : null;

        // 2. Read Struktur Pengurus Kelas
        $positions = collect();
        if ($ClassPositionModel) {
            $positions = $ClassPositionModel::where('class_id', $classId)
                ->with('member')
                ->get();
        }

        // 3. Read Daftar Anggota Siswa (Support fleksibel nama kolom status)
        $members = collect();
        if ($MemberModel) {
            $query = $MemberModel::where('class_id', $classId);

            if (\Illuminate\Support\Facades\Schema::hasColumn('members', 'member_status')) {
                $query->where('member_status', 'ACTIVE');
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('members', 'status')) {
                $query->where('status', 'ACTIVE');
            }

            $members = $query->orderBy('name', 'asc')->get();
        }

        return view('pages.public.about', compact('profile', 'positions', 'members'));
    }
}