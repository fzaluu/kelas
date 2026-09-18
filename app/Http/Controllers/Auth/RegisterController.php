<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\Core\ClassMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nis'       => ['required', 'string', 'max:20', 'unique:class_members,nis'],
            'full_name' => ['required', 'string', 'max:100'],
            'gender'    => ['required', 'in:L,P'],
            'username'  => ['required', 'string', 'max:50', 'unique:users,username'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat User Account dengan Status PENDING
            $user = User::create([
                'name'            => $request->full_name,
                'username'        => $request->username,
                'email'           => $request->email,
                'password'        => Hash::make($request->password),
                'role'            => 'siswa',
                'status'          => 'ACTIVE',
                'approval_status' => 'PENDING', // 👈 Butuh persetujuan Dev
            ]);

            // 2. Buat Draf Biodata Siswa
            ClassMember::create([
                'user_id'   => $user->id,
                'nis'       => $request->nis,
                'full_name' => $request->full_name,
                'gender'    => $request->gender,
                'status'    => 'ACTIVE',
            ]);
        });

        return redirect()->route('login')
            ->with('success', '🎉 Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan dari Developer.');
    }
}