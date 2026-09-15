<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\Core\Role;
use App\Http\Requests\Development\UserStoreRequest;
use App\Http\Requests\Development\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        return view('pages.development.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('id', 'asc')->get();
        return view('pages.development.users.create', compact('roles'));
    }

    public function store(UserStoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'username' => $request->username,
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'status'   => 'ACTIVE',
            ]);

            $user->roles()->attach($request->role_id, [
                'assigned_at' => now(),
            ]);
        });

        return redirect()->route('development.users.index')
            ->with('success', 'User baru berhasil ditambahkan!');
    }

    /**
     * Form Edit User
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::orderBy('id', 'asc')->get();
        return view('pages.development.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User Data
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        DB::transaction(function () use ($request, $user) {
            $data = [
                'username' => $request->username,
                'name'     => $request->name,
                'email'    => $request->email,
            ];

            // Update password jika diisi
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // Sync role baru di pivot table
            $user->roles()->sync([$request->role_id => ['assigned_at' => now()]]);
        });

        return redirect()->route('development.users.index')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Hapus User
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Proteksi agar akun dev tidak terhapus
        if ($user->username === 'dev') {
            return redirect()->back()->with('error', 'Akun Master Developer tidak dapat dihapus!');
        }

        DB::transaction(function () use ($user) {
            $user->roles()->detach();
            $user->delete();
        });

        return redirect()->route('development.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}