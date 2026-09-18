<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\Member;
use App\Models\Core\SchoolClass;
use App\Http\Requests\Development\MemberStoreRequest;
use App\Http\Requests\Development\MemberUpdateRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with(['schoolClass', 'user'])->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $members = $query->paginate(15)->withQueryString();

        return view('pages.development.members.index', compact('members'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('pages.development.members.create', compact('classes'));
    }

    public function store(MemberStoreRequest $request)
    {
        Member::create($request->validated());

        return redirect()->route('development.members.index')
            ->with('success', 'Data anggota berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        $classes = SchoolClass::all();
        return view('pages.development.members.edit', compact('member', 'classes'));
    }

    public function update(MemberUpdateRequest $request, Member $member)
    {
        $member->update($request->validated());

        return redirect()->route('development.members.index')
            ->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('development.members.index')
            ->with('success', 'Data anggota berhasil dihapus!');
    }
}