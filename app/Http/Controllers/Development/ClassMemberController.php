<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\ClassMember;
use App\Models\Core\User;
use App\Http\Requests\Development\ClassMemberStoreRequest;
use App\Http\Requests\Development\ClassMemberUpdateRequest;
use Illuminate\Http\Request;

class ClassMemberController extends Controller
{
    /**
     * Tampilkan daftar anggota kelas.
     */
    public function index(Request $request)
    {
        $query = ClassMember::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->paginate(10)->withQueryString();

        return view('pages.development.members.index', compact('members'));
    }

    /**
     * Form tambah anggota kelas baru.
     */
    public function create()
    {
        $users = User::orderBy('username', 'asc')->get();
        return view('pages.development.members.create', compact('users'));
    }

    /**
     * Simpan data anggota kelas ke database.
     */
    public function store(ClassMemberStoreRequest $request)
    {
        ClassMember::create($request->validated());

        return redirect()->route('development.members.index')
            ->with('success', 'Anggota kelas baru berhasil ditambahkan!');
    }

    /**
     * Form edit data anggota kelas.
     */
    public function edit($id)
    {
        $member = ClassMember::findOrFail($id);
        $users = User::orderBy('username', 'asc')->get();

        return view('pages.development.members.edit', compact('member', 'users'));
    }

    /**
     * Update data anggota kelas.
     */
    public function update(ClassMemberUpdateRequest $request, $id)
    {
        $member = ClassMember::findOrFail($id);
        $member->update($request->validated());

        return redirect()->route('development.members.index')
            ->with('success', 'Data anggota kelas berhasil diperbarui!');
    }

    /**
     * Hapus data anggota kelas.
     */
    public function destroy($id)
    {
        $member = ClassMember::findOrFail($id);
        $member->delete();

        return redirect()->route('development.members.index')
            ->with('success', 'Anggota kelas berhasil dihapus!');
    }
}