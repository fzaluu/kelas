<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Media\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaFile::with('uploader')->latest();

        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%');
        }

        $mediaFiles = $query->paginate(12)->withQueryString();

        return view('pages.development.media.index', compact('mediaFiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240'], // Maksimal 10MB
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $mimeType = $file->getClientMimeType();
        
        $randomName = time() . '_' . Str::random(10);
        $directory = 'uploads/media';

        // Cek apakah file merupakan gambar yang bisa dikonversi ke WebP
        $isImage = str_starts_with($mimeType, 'image/') && in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);

        if ($isImage && function_exists('imagewebp')) {
            $storedName = $randomName . '.webp';
            $storagePath = $directory . '/' . $storedName;
            $fullPath = storage_path('app/public/' . $storagePath);

            // Pastikan direktori tujuan tersedia
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            // Konversi gambar menggunakan GD library bawaan PHP
            $imageResource = match ($extension) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($file->getRealPath()),
                'png'        => @imagecreatefrompng($file->getRealPath()),
                'webp'       => @imagecreatefromwebp($file->getRealPath()),
                default      => null,
            };

            if ($imageResource) {
                // Tangani transparansi jika PNG/WebP
                imagepalettetotruecolor($imageResource);
                imagealphablending($imageResource, true);
                imagesavealpha($imageResource, true);

                // Simpan ke format WebP dengan kualitas 80% (Presisi tinggi, ukuran sangat kecil)
                imagewebp($imageResource, $fullPath, 80);
                imagedestroy($imageResource);

                $mimeType = 'image/webp';
                $extension = 'webp';
                $fileSize = filesize($fullPath);
            } else {
                // Fallback jika pemrosesan gambar gagal
                $storedName = $randomName . '.' . $extension;
                $storagePath = $file->storeAs($directory, $storedName, 'public');
                $fileSize = $file->getSize();
            }
        } else {
            // Jika dokumen non-gambar (PDF, Word, Excel, dll)
            $storedName = $randomName . '.' . $extension;
            $storagePath = $file->storeAs($directory, $storedName, 'public');
            $fileSize = $file->getSize();
        }

        MediaFile::create([
            'original_name' => $originalName,
            'stored_name'   => $storedName,
            'mime_type'     => $mimeType,
            'extension'     => $extension,
            'size'          => $fileSize,
            'storage_disk'  => 'public',
            'storage_path'  => $storagePath,
            'visibility'    => 'MEMBER',
            'status'        => 'ACTIVE',
            'uploaded_by'   => auth()->id(),
        ]);

        return redirect()->route('development.media.index')
            ->with('success', "File {$originalName} berhasil diunggah dan dioptimasi.");
    }

    public function update(Request $request, MediaFile $medium)
    {
        $request->validate([
            'original_name' => ['required', 'string', 'max:255'],
        ]);

        $medium->update([
            'original_name' => $request->original_name,
        ]);

        return redirect()->back()->with('success', 'Nama file berhasil diperbarui!');
    }

    public function destroy(MediaFile $medium)
    {
        if (Storage::disk($medium->storage_disk)->exists($medium->storage_path)) {
            Storage::disk($medium->storage_disk)->delete($medium->storage_path);
        }

        $medium->delete();

        return redirect()->route('development.media.index')
            ->with('success', 'File berhasil dihapus dari media manager.');
    }
}