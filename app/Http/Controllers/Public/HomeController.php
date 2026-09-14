<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class HomeController extends Controller
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

    public function index()
    {
        $classId = 1; // Default Scope XI PPLG 2

        // Resolve Model Classes
        $ClassProfileModel = $this->getModelClass('ClassProfile', 'Core');
        $MemberModel       = $this->getModelClass('Member', 'Core');
        $AnnouncementModel = $this->getModelClass('Announcement', 'Content');
        $AgendaModel       = $this->getModelClass('Agenda', 'Content');
        $GalleryModel      = $this->getModelClass('Gallery', 'Content');
        $ProjectModel      = $this->getModelClass('Project', 'Content');
        $AppreciationModel = $this->getModelClass('Appreciation', 'Content');

        // 1. Profil Kelas
        $profile = $ClassProfileModel ? $ClassProfileModel::where('class_id', $classId)->first() : null;

        // 2. Total Anggota
        $totalMembers = $MemberModel ? $MemberModel::where('class_id', $classId)->where('member_status', 'ACTIVE')->count() : 32;

        // 3. Top 3 Pengumuman Publik & Aktif
        $announcements = collect();
        if ($AnnouncementModel) {
            $announcements = $AnnouncementModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', now());
                })
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();
        }

        // 4. Top 3 Agenda Terdekat
        $agendas = collect();
        if ($AgendaModel) {
            $agendas = $AgendaModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('start_at', '>=', now())
                ->orderBy('start_at', 'asc')
                ->take(3)
                ->get();
        }

        // 5. Preview 4 Album Galeri Terbaru
        $galleries = collect();
        if ($GalleryModel) {
            $galleries = $GalleryModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('visibility', 'PUBLIC')
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();
        }

        // 6. Top 2 Featured Projects
        $featuredProjects = collect();
        if ($ProjectModel) {
            $featuredProjects = $ProjectModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('visibility', 'PUBLIC')
                ->take(2)
                ->get();
        }

        // 7. Top 2 Apresiasi / Prestasi Terbaru
        $appreciations = collect();
        if ($AppreciationModel) {
            $appreciations = $AppreciationModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('visibility', 'PUBLIC')
                ->orderBy('achievement_date', 'desc')
                ->take(2)
                ->get();
        }

        // 8. Preview 6 Anggota Kelas (Hanya Filter member_status ACTIVE)
        $members = collect();
        if ($MemberModel) {
            $members = $MemberModel::where('class_id', $classId)
                ->where('member_status', 'ACTIVE')
                ->take(6)
                ->get();
        }

        return view('pages.public.home', compact(
            'profile',
            'totalMembers',
            'announcements',
            'agendas',
            'galleries',
            'featuredProjects',
            'appreciations',
            'members'
        ));
    }
}