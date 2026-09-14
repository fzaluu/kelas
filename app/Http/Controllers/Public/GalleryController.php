<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class GalleryController extends Controller
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

    // 📸 1. Kegiatan Kelas (Album Foto)
    public function activities()
    {
        $classId = 1;
        $GalleryModel = $this->getModelClass('Gallery', 'Content');

        $albums = collect();
        if ($GalleryModel) {
            $albums = $GalleryModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('visibility', 'PUBLIC')
                ->with(['items.mediaFile'])
                ->orderBy('published_at', 'desc')
                ->paginate(6);
        }

        return view('pages.public.gallery.activities', compact('albums'));
    }

    // 💻 2. Karya & Project Showcase
    public function projects()
    {
        $classId = 1;
        $ProjectModel = $this->getModelClass('Project', 'Content');

        $projects = collect();
        if ($ProjectModel) {
            $projects = $ProjectModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('visibility', 'PUBLIC')
                ->with(['members.member'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pages.public.gallery.projects', compact('projects'));
    }

    // 🏆 3. Prestasi Siswa
    public function appreciations()
    {
        $classId = 1;
        $AppreciationModel = $this->getModelClass('Appreciation', 'Content');

        $appreciations = collect();
        if ($AppreciationModel) {
            $appreciations = $AppreciationModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('visibility', 'PUBLIC')
                ->with(['members.member'])
                ->orderBy('achievement_date', 'desc')
                ->get();
        }

        return view('pages.public.gallery.appreciations', compact('appreciations'));
    }
}