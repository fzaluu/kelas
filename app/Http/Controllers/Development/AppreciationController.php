<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Content\Appreciation;
use App\Models\Content\AppreciationMedia;
use App\Models\Content\AppreciationMember;
use App\Models\Core\Member;
use App\Models\Core\SchoolClass;
use App\Models\Media\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppreciationController extends Controller
{
    public function index(Request $request)
    {
        $classId = SchoolClass::getActiveId();
        $query = Appreciation::where('class_id', $classId)->with(['appreciationMedia.mediaFile', 'members.member'])->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $appreciations = $query->paginate(12)->withQueryString();

        return view('pages.development.public.content.appreciations.index', compact('appreciations'));
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

        return view('pages.development.public.content.appreciations.create', compact('imageFiles', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'category'         => ['required', 'string'],
            'achievement_date' => ['required', 'date'],
            'media_file_id'    => ['required', 'exists:media_files,id'],
            'member_ids'       => ['nullable', 'array'],
            'member_ids.*'     => ['exists:members,id'],
            'status'           => ['required', 'in:DRAFT,PUBLISHED,ARCHIVED'],
            'visibility'       => ['required', 'in:PUBLIC,MEMBER,RESTRICTED'],
        ]);

        DB::transaction(function () use ($request) {
            $classId = SchoolClass::getActiveId();

            $appreciation = Appreciation::create([
                'class_id'         => $classId,
                'title'            => $request->title,
                'description'      => $request->description,
                'category'         => $request->category,
                'achievement_date' => $request->achievement_date,
                'status'           => $request->status,
                'visibility'       => $request->visibility,
                'published_at'     => $request->status === 'PUBLISHED' ? now() : null,
                'created_by'       => auth()->id(),
            ]);

            // Hubungkan Media Gambar ke Tabel Pivot appreciation_media
            AppreciationMedia::create([
                'appreciation_id' => $appreciation->id,
                'media_file_id'   => $request->media_file_id,
                'sort_order'      => 1,
            ]);

            // Hubungkan Siswa Berprestasi ke Tabel Pivot appreciation_members
            if ($request->filled('member_ids')) {
                foreach ($request->member_ids as $memberId) {
                    AppreciationMember::create([
                        'appreciation_id' => $appreciation->id,
                        'member_id'       => $memberId,
                    ]);
                }
            }
        });

        return redirect()->route('development.content.appreciations.index')
            ->with('success', 'Data prestasi/apresiasi berhasil ditambahkan!');
    }

    public function show(Appreciation $appreciation)
    {
        return redirect()->route('development.content.appreciations.index');
    }

    public function destroy(Appreciation $appreciation)
    {
        DB::transaction(function () use ($appreciation) {
            $appreciation->members()->delete();
            $appreciation->appreciationMedia()->delete();
            $appreciation->delete();
        });

        return redirect()->route('development.content.appreciations.index')
            ->with('success', 'Data prestasi berhasil dihapus.');
    }
}