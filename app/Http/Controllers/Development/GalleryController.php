<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Content\Gallery;
use App\Models\Media\MediaFile;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with(['mediaFile', 'creator'])->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $galleries = $query->paginate(12)->withQueryString();

        return view('pages.development.public.galleries.index', compact('galleries'));
    }

    public function create()
    {
        $imageFiles = MediaFile::where('mime_type', 'like', 'image/%')->latest()->get();
        return view('pages.development.public.galleries.create', compact('imageFiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'category'      => ['required', 'in:ACTIVITY,PROJECT,APPRECIATION,OTHER'],
            'media_file_id' => ['required', 'exists:media_files,id'],
            'status'        => ['required', 'in:DRAFT,PUBLISHED,ARCHIVED'],
            'visibility'    => ['required', 'in:PUBLIC,MEMBER,RESTRICTED'],
            'description'   => ['nullable', 'string'],
        ]);

        $publishedAt = $request->status === 'PUBLISHED' ? now() : null;

        Gallery::create([
            'class_id'      => 1,
            'title'         => $request->title,
            'category'      => $request->category,
            'media_file_id' => $request->media_file_id,
            'status'        => $request->status,
            'visibility'    => $request->visibility,
            'published_at'  => $publishedAt,
            'description'   => $request->description,
            'created_by'    => auth()->id(),
        ]);

        return redirect()->route('development.public.galleries.index')
            ->with('success', 'Foto kegiatan berhasil ditambahkan ke galeri!');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('development.public.galleries.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}