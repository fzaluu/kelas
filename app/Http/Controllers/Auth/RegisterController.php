<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\Core\Role;
use Illuminate\Http\Request;
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
            'nis'       => ['required', 'string', 'max:20'],
            'full_name' => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', 'unique:users,username'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($request) {
            $studentRole = Role::where('name', 'student')->first();

            $user = User::create([
                'username'        => $request->username,
                'email'           => $request->email,
                'password'        => $request->password,
                'status'          => 'INACTIVE', // Belum aktif sampai diapprove
                'approval_status' => 'PENDING',
            ]);

            if ($studentRole) {
                $user->roles()->attach($studentRole->id, [
                    'assigned_at' => now(),
                ]);
            }
        });

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil dikirim! Akun Anda sedang menunggu persetujuan pengurus/admin.');
    }
}