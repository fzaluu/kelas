<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\Core\Member;
use App\Models\Core\Role;
use App\Http\Requests\Development\UserStoreRequest;
use App\Http\Requests\Development\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['member', 'roles'])->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhereHas('member', function ($mq) use ($request) {
                      $mq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('pages.development.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        // Mengambil siswa/member yang belum terikat dengan akun user mana pun
        $unlinkedMembers = Member::whereDoesntHave('user')->orderBy('name', 'asc')->get();

        return view('pages.development.users.create', compact('roles', 'unlinkedMembers'));
    }

    public function store(UserStoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'member_id' => $request->member_id,
                'username'  => $request->username,
                'email'     => $request->email,
                'password'  => $request->password,
                'status'    => $request->status ?? 'ACTIVE',
            ]);

            $user->roles()->attach($request->role_id, [
                'assigned_at' => now(),
                'assigned_by' => auth()->id(),
            ]);
        });

        return redirect()->route('development.users.index')
            ->with('success', 'Pengguna berhasil dibuat dan terhubung dengan role!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load(['roles', 'member']);
        
        $unlinkedMembers = Member::whereDoesntHave('user')
            ->orWhere('id', $user->member_id)
            ->orderBy('name', 'asc')
            ->get();

        return view('pages.development.users.edit', compact('user', 'roles', 'unlinkedMembers'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        DB::transaction(function () use ($request, $user) {
            $data = [
                'member_id' => $request->member_id,
                'username'  => $request->username,
                'email'     => $request->email,
                'status'    => $request->status,
            ];

            if ($request->filled('password')) {
                $data['password'] = $request->password;
            }

            $user->update($data);
            $user->roles()->sync([$request->role_id => [
                'assigned_at' => now(),
                'assigned_by' => auth()->id(),
            ]]);
        });

        return redirect()->route('development.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->username === 'dev') {
            return redirect()->back()->with('error', 'Akun Master Developer tidak dapat dihapus!');
        }

        DB::transaction(function () use ($user) {
            $user->roles()->detach();
            $user->delete();
        });

        return redirect()->route('development.users.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}