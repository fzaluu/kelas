<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Content\Project;
use App\Models\Content\ProjectMedia;
use App\Models\Content\ProjectMember;
use App\Models\Core\Member;
use App\Models\Core\SchoolClass;
use App\Models\Media\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $classId = SchoolClass::getActiveId();
        $query = Project::where('class_id', $classId)->with(['projectMedia.mediaFile', 'members.member'])->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $projects = $query->paginate(12)->withQueryString();

        return view('pages.development.public.content.projects.index', compact('projects'));
    }

    public function create()
    {
        $classId = SchoolClass::getActiveId();

        // Ambil gambar secara fleksibel berdasarkan kolom yang ada di media_files
        $mediaQuery = MediaFile::query();
        if (Schema::hasColumn('media_files', 'mime_type')) {
            $mediaQuery->where('mime_type', 'like', 'image/%');
        } elseif (Schema::hasColumn('media_files', 'file_type')) {
            $mediaQuery->where('file_type', 'like', 'image/%')->orWhere('file_type', 'IMAGE');
        }

        $imageFiles = $mediaQuery->latest()->get();
        $members = Member::where('class_id', $classId)->orderBy('name', 'asc')->get();

        return view('pages.development.public.content.projects.create', compact('imageFiles', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'media_file_id' => ['required', 'exists:media_files,id'],
            'member_ids'    => ['nullable', 'array'],
            'member_ids.*'  => ['exists:members,id'],
            'status'        => ['required', 'in:DRAFT,PUBLISHED,ARCHIVED'],
            'visibility'    => ['required', 'in:PUBLIC,MEMBER,RESTRICTED'],
        ]);

        DB::transaction(function () use ($request) {
            $classId = SchoolClass::getActiveId();

            $project = Project::create([
                'class_id'     => $classId,
                'title'        => $request->title,
                'slug'         => Str::slug($request->title) . '-' . time(),
                'description'  => $request->description,
                'status'       => $request->status,
                'visibility'   => $request->visibility,
                'published_at' => $request->status === 'PUBLISHED' ? now() : null,
                'created_by'   => auth()->id(),
            ]);

            // Hubungkan Media Gambar ke Tabel Pivot project_media
            ProjectMedia::create([
                'project_id'    => $project->id,
                'media_file_id' => $request->media_file_id,
                'sort_order'    => 1,
            ]);

            // Hubungkan Anggota Tim ke Tabel Pivot project_members
            if ($request->filled('member_ids')) {
                foreach ($request->member_ids as $memberId) {
                    ProjectMember::create([
                        'project_id' => $project->id,
                        'member_id'  => $memberId,
                    ]);
                }
            }
        });

        return redirect()->route('development.content.projects.index')
            ->with('success', 'Karya/Project siswa berhasil ditambahkan!');
    }

    public function show(Project $project)
    {
        return redirect()->route('development.content.projects.index');
    }

    public function destroy(Project $project)
    {
        DB::transaction(function () use ($project) {
            $project->members()->delete();
            $project->projectMedia()->delete();
            $project->delete();
        });

        return redirect()->route('development.content.projects.index')
            ->with('success', 'Karya/Project berhasil dihapus.');
    }
}