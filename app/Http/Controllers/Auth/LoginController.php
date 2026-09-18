<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $identity = $request->username;
        $password = $request->password;

        // Cari user berdasarkan Email ATAU Username
        $user = User::where('email', $identity)
                    ->orWhere('username', $identity)
                    ->first();

        // Verifikasi User & Password
        if ($user && Hash::check($password, $user->password)) {
            
            // 1. Cek Status Persetujuan (Approval Gate)
            if ($user->approval_status === 'PENDING') {
                return back()->with('error', '⚠️ Akun Anda masih dalam proses peninjauan oleh Developer. Silakan hubungi Dev untuk persetujuan.')->withInput();
            }

            if ($user->approval_status === 'REJECTED') {
                return back()->with('error', '❌ Pendaftaran akun Anda tidak disetujui oleh Developer.')->withInput();
            }

            // 2. Cek Status Keaktifan Akun
            if ($user->status !== 'ACTIVE') {
                return back()->with('error', '🔒 Akun Anda dinonaktifkan oleh administrator.')->withInput();
            }

            // Login pengguna
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Redirect sesuai Role masing-masing
            return $this->redirectUserByRole($user);
        }

        return back()->with('error', 'Username/Email atau password yang Anda masukkan salah.')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    protected function redirectUserByRole($user)
    {
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole('development')) return redirect()->intended(route('development.dashboard'));
            if ($user->hasRole('walikelas'))   return redirect()->intended(route('teacher.attendance.index'));
            if ($user->hasRole('ketuakelas'))  return redirect()->intended(route('home'));
            if ($user->hasRole('bendahara'))   return redirect()->intended(route('home'));
            if ($user->hasRole('sekretaris'))  return redirect()->intended(route('home'));
        }

        return redirect()->intended(route('home'));
    }
}