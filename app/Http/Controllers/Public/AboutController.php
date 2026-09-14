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
        $classId = 1; // Scope XI PPLG 2

        $ClassProfileModel  = $this->getModelClass('ClassProfile', 'Core');
        $ClassPositionModel = $this->getModelClass('ClassPosition', 'Core');
        $MemberModel        = $this->getModelClass('Member', 'Core');

        // 1. Read Profil & Identitas Kelas
        $profile = $ClassProfileModel ? $ClassProfileModel::where('class_id', $classId)->first() : null;

        // 2. Read Struktur Pengurus (Diurutkan berdasarkan ID)
        $positions = collect();
        if ($ClassPositionModel) {
            $positions = $ClassPositionModel::where('class_id', $classId)
                ->with('member')
                ->orderBy('id', 'asc')
                ->get();
        }

        // 3. Read Daftar Anggota Aktif
        $members = collect();
        if ($MemberModel) {
            $members = $MemberModel::where('class_id', $classId)
                ->where('member_status', 'ACTIVE')
                ->orderBy('name', 'asc')
                ->get();
        }

        return view('pages.public.about', compact('profile', 'positions', 'members'));
    }
}