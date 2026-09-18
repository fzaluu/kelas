<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Content\Gallery;
use Illuminate\Http\Request;

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

    // 📸 1. Galeri Kegiatan
    public function activities()
    {
        $classId = 1;

        $galleries = Gallery::where('class_id', $classId)
            ->where('status', 'PUBLISHED')
            ->where('category', 'ACTIVITY')
            ->with(['mediaFile', 'creator'])
            ->latest('published_at')
            ->paginate(12);

        return view('pages.public.gallery.activities', compact('galleries'));
    }

    // 🚀 2. Karya & Project Showcase
    public function projects()
    {
        $classId = 1;
        $ProjectModel = $this->getModelClass('Project', 'Content');

        $projects = collect();

        if ($ProjectModel) {
            $projects = $ProjectModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->with(['members.member'])
                ->latest()
                ->get();
        }

        // Fallback jika belum mengisi tabel projects khusus, ambil dari Galeri berkategori PROJECT
        if ($projects->isEmpty()) {
            $projects = Gallery::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('category', 'PROJECT')
                ->with(['mediaFile'])
                ->latest()
                ->get();
        }

        return view('pages.public.gallery.projects', compact('projects'));
    }

    // 🏆 3. Prestasi & Apresiasi
    public function appreciations()
    {
        $classId = 1;
        $AppreciationModel = $this->getModelClass('Appreciation', 'Content');

        $appreciations = collect();

        if ($AppreciationModel) {
            $appreciations = $AppreciationModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->with(['members.member'])
                ->latest('achievement_date')
                ->get();
        }

        // Fallback jika belum mengisi tabel appreciations khusus, ambil dari Galeri berkategori APPRECIATION
        if ($appreciations->isEmpty()) {
            $appreciations = Gallery::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('category', 'APPRECIATION')
                ->with(['mediaFile'])
                ->latest()
                ->get();
        }

        return view('pages.public.gallery.appreciations', compact('appreciations'));
    }
}