<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Helper privat untuk resolve nama kelas Model secara fleksibel
     */
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
        $classId = 1; // XI PPLG 2 Scope
        
        $ClassProfileModel = $this->getModelClass('ClassProfile', 'Core');
        
        // Membaca deskripsi & profil kelas dari database
        $profile = $ClassProfileModel ? $ClassProfileModel::where('class_id', $classId)->first() : null;

        return view('pages.public.contact', compact('profile'));
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'message' => 'required|string|max:1000',
        ]);

        return back()->with('success', 'Terima kasih! Pesan dan masukan Anda berhasil terkirim.');
    }
}