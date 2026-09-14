<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Core\User; // Sesuaikan dengan model User kamu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
            'identity' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 1. Throttle / Rate Limiter Key (Maksimal 5x percobaan per IP + Identity)
        $throttleKey = Str::lower($request->input('identity')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
                'throttle' => "Terlalu banyak percobaan gagal. Akses dibekukan sementara. Silakan tunggu {$minutes} menit ({$seconds} detik) lagi.",
            ])->onlyInput('identity');
        }

        $identity = $request->identity;
        $password = $request->password;
        $fieldType = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 2. Cek apakah Email / NISN ada di Database
        $userExists = User::where($fieldType, $identity)->exists();

        // 3. Coba Autentikasi
        if (Auth::attempt([$fieldType => $identity, 'password' => $password], $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey); // Reset limiter jika berhasil
            $request->session()->regenerate();
            return $this->redirectUserByRole(Auth::user());
        }

        // Catat kegagalan login
        RateLimiter::hit($throttleKey, 120); // Lockout 2 menit (120 detik)

        // 4. Kondisional Error Response
        // Jika Email/NISN Benar, Password Salah
        if ($userExists) {
            return back()->withErrors([
                'password_error' => 'Kata sandi yang Anda masukkan salah.',
            ])->onlyInput('identity');
        }

        // Jika Email/NISN Tidak Ditemukan
        return back()->withErrors([
            'identity_error' => 'Akun tidak ditemukan atau belum terdaftar.',
        ])->onlyInput('identity');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    protected function redirectUserByRole($user)
    {
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole('development')) return redirect()->intended(route('development.dashboard'));
            if ($user->hasRole('walikelas'))   return redirect()->intended(route('teacher.dashboard'));
            if ($user->hasRole('ketuakelas'))  return redirect()->intended(route('leader.dashboard'));
            if ($user->hasRole('bendahara'))   return redirect()->intended(route('treasurer.dashboard'));
            if ($user->hasRole('sekretaris'))  return redirect()->intended(route('secretary.dashboard'));
        }

        // Default untuk siswa biasa
        return redirect()->intended(route('student.dashboard'));
    }
}