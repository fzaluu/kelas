<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Content\Gallery;
use App\Models\Core\SchoolClass;
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

    // 📸 1. Halaman Publik: Galeri Foto Kegiatan
    public function activities()
    {
        $classId = SchoolClass::getActiveId(); // ✅ Dinamis via SchoolClass

        $galleries = Gallery::where('class_id', $classId)
            ->where('status', 'PUBLISHED')
            ->where('category', 'ACTIVITY')
            ->with(['galleryMedia.mediaFile', 'creator'])
            ->latest('published_at')
            ->paginate(12);

        return view('pages.public.gallery.activities', compact('galleries'));
    }

    // 🚀 2. Halaman Publik: Karya & Project Showcase
    public function projects()
    {
        $classId = \App\Models\Core\SchoolClass::getActiveId();

        $projects = \App\Models\Content\Project::where('class_id', $classId)
            ->where('status', 'PUBLISHED')
            ->with(['members.member', 'projectMedia.mediaFile'])
            ->latest()
            ->get();

        return view('pages.public.gallery.projects', compact('projects'));
    }

    // 🏆 3. Halaman Publik: Prestasi & Apresiasi
    public function appreciations()
    {
        $classId = \App\Models\Core\SchoolClass::getActiveId();

        $appreciations = \App\Models\Content\Appreciation::where('class_id', $classId)
            ->where('status', 'PUBLISHED')
            ->with(['members.member', 'appreciationMedia.mediaFile'])
            ->latest('achievement_date')
            ->get();

        return view('pages.public.gallery.appreciations', compact('appreciations'));
    }
}