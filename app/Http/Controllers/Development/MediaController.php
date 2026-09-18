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
        $extension = $file->getClientOriginalExtension();
        $storedName = time() . '_' . Str::random(10) . '.' . $extension;
        $storagePath = $file->storeAs('uploads/media', $storedName, 'public');

        MediaFile::create([
            'original_name' => $originalName,
            'stored_name'   => $storedName,
            'mime_type'     => $file->getClientMimeType(),
            'extension'     => $extension,
            'size'          => $file->getSize(),
            'storage_disk'  => 'public',
            'storage_path'  => $storagePath,
            'visibility'    => 'MEMBER',
            'status'        => 'ACTIVE',
            'uploaded_by'   => auth()->id(),
        ]);

        return redirect()->route('development.media.index')
            ->with('success', "File {$originalName} berhasil diunggah.");
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
}