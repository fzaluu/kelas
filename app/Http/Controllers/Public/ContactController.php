<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        // 1. Validasi Input Formulir
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'message' => 'required|string|max:1000',
        ]);

        // 2. Deteksi Nama Tabel Feedback di Database
        $tableName = 'feedback_messages';
        if (!Schema::hasTable($tableName)) {
            if (Schema::hasTable('feedbacks')) {
                $tableName = 'feedbacks';
            } elseif (Schema::hasTable('messages')) {
                $tableName = 'messages';
            }
        }

        // 3. Susun Data Sesuai Kolom yang Tersedia di Tabel
        $insertData = [];

        if (Schema::hasColumn($tableName, 'sender_name')) {
            $insertData['sender_name']  = $request->name;
            $insertData['sender_email'] = $request->email;
            $insertData['content']      = $request->message;
        } else {
            $insertData['name']    = $request->name;
            $insertData['email']   = $request->email;
            $insertData['message'] = $request->message;
        }

        if (Schema::hasColumn($tableName, 'class_id')) {
            $insertData['class_id'] = 1;
        }

        if (Schema::hasColumn($tableName, 'subject')) {
            $insertData['subject'] = 'PESAN KONTAK';
        }

        $insertData['created_at'] = now();
        $insertData['updated_at'] = now();

        // 4. Simpan ke Database
        DB::table($tableName)->insert($insertData);

        return back()->with('success', 'Terima kasih! Pesan dan masukan Anda berhasil terkirim dan tersimpan.');
    }
}