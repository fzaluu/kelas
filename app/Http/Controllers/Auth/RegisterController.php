<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Core\AccountRegistration;
use Illuminate\Http\Request;

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
            'nisn'      => ['nullable', 'string', 'max:20'],
            'full_name' => ['required', 'string', 'max:255'],
            'gender'    => ['required', 'in:L,P'],
            'username'  => ['required', 'string', 'max:255', 'unique:users,username', 'unique:account_registrations,username'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email', 'unique:account_registrations,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        AccountRegistration::create([
            'nis'       => $request->nis,
            'nisn'      => $request->nisn,
            'full_name' => $request->full_name,
            'gender'    => $request->gender,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => $request->password, // Otomatis di-hash oleh casts Model
            'status'    => 'PENDING',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil dikirim! Akun Anda sedang dalam antrean verifikasi oleh administrator.');
    }
}