<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Media\ClassDocument;
use App\Models\Media\MediaFile;
use Illuminate\Http\Request;

class ClassDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassDocument::with(['mediaFile', 'creator'])->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $documents = $query->paginate(10)->withQueryString();

        return view('pages.development.public.documents.index', compact('documents'));
    }

    public function create()
    {
        $mediaFiles = MediaFile::latest()->get();
        return view('pages.development.public.documents.create', compact('mediaFiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'category'      => ['required', 'in:ADMINISTRATION,STUDENT,ARCHIVE,OTHER'], // ✅ Sesuai ENUM Migration
            'media_file_id' => ['required', 'exists:media_files,id'],
            'description'   => ['nullable', 'string'],
            'status'        => ['required', 'in:ACTIVE,ARCHIVED'], // ✅ Sesuai ENUM Migration
        ]);

        ClassDocument::create([
            'class_id'      => 1, // Default XI PPLG 2
            'title'         => $request->title,
            'category'      => $request->category,
            'media_file_id' => $request->media_file_id,
            'description'   => $request->description,
            'status'        => $request->status,
            'created_by'    => auth()->id(), // ✅ Menggunakan created_by sesuai migration
        ]);

        return redirect()->route('development.public.documents.index')
            ->with('success', 'Dokumen kelas berhasil dipublikasikan!');
    }

    public function destroy(ClassDocument $document)
    {
        $document->delete();

        return redirect()->route('development.public.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}