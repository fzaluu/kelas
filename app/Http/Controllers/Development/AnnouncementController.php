<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Content\Announcement; // ✅ Model Content
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $announcements = $query->paginate(10)->withQueryString();

        // 👈 PERBAIKAN: Tambahkan .public. di path view
        return view('pages.development.public.announcements.index', compact('announcements'));
    }

    public function create()
    {
        // 👈 PERBAIKAN: Tambahkan .public. di path view
        return view('pages.development.public.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'content'  => ['required', 'string'],
            'category' => ['required', 'string'],
            'priority' => ['required', 'in:NORMAL,IMPORTANT,URGENT'],
            'status'   => ['required', 'in:DRAFT,PUBLISHED,ARCHIVED'],
        ]);

        Announcement::create([
            'class_id'     => 1,
            'title'        => $request->title,
            'slug'         => Str::slug($request->title) . '-' . time(),
            'content'      => $request->content,
            'category'     => $request->category,
            'priority'     => $request->priority,
            'status'       => $request->status,
            'published_at' => $request->status === 'PUBLISHED' ? now() : null,
            'created_by'   => auth()->id(),
        ]);

        return redirect()->route('development.public.announcements.index')
            ->with('success', 'Pengumuman berhasil dipublikasikan!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('development.public.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}