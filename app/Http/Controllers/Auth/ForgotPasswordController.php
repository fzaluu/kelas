<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        $nisnAttempts = session('nisn_fail_count', 0);
        $useDevCode   = $nisnAttempts >= 5;

        return view('pages.auth.forgot-password', compact('useDevCode', 'nisnAttempts'));
    }

    public function sendResetLink(Request $request)
    {
        $throttleKey = 'forgot-password:' . $request->ip();

        // 1. Cek Apakah Kena Lockout (Salah 3x -> Ban 1 Menit)
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "⏳ Terlalu banyak percobaan salah. Silakan tunggu {$seconds} detik lagi untuk mengakses halaman ini.")->withInput();
        }

        $nisnAttempts = session('nisn_fail_count', 0);
        $isDevCodeMode = $nisnAttempts >= 5;

        // Validasi Input
        $rules = [
            'identity' => ['required', 'string'],
        ];

        if ($isDevCodeMode) {
            $rules['dev_code'] = ['required', 'string'];
        } else {
            $rules['nisn'] = ['required', 'string'];
        }

        $request->validate($rules);

        // 2. Cari User Berdasarkan Email / Username
        $user = User::where('email', $request->identity)
                    ->orWhere('username', $request->identity)
                    ->first();

        // Jika Email / Username Salah Total
        if (!$user) {
            RateLimiter::hit($throttleKey, 60); // Tambah hit percobaan salah (expire 1 menit)
            $attemptsLeft = RateLimiter::remaining($throttleKey, 3);
            return back()->with('error', "❌ Akun tidak ditemukan. Sisa percobaan: {$attemptsLeft} kali.")->withInput();
        }

        // 3. Verifikasi NISN / Dev Code
        $isNisnValid = false;

        if ($isDevCodeMode) {
            // Mode Kode Dev
            if ($request->dev_code === 'aduhfrazaganteng') {
                $isNisnValid = true;
            } else {
                RateLimiter::hit($throttleKey, 60);
                return back()->with('error', '❌ Kode Dev salah!')->withInput();
            }
        } else {
            // Mode NISN Biasa (Cek ke relasi classMember)
            $userNisn = $user->classMember->nisn ?? null;
            if ($userNisn && $userNisn === $request->nisn) {
                $isNisnValid = true;
            }
        }

        // Jika NISN Salah
        if (!$isNisnValid) {
            RateLimiter::hit($throttleKey, 60);
            session(['nisn_fail_count' => $nisnAttempts + 1]);

            $newFailCount = session('nisn_fail_count');
            if ($newFailCount >= 5) {
                return back()->with('error', '⚠️ NISN salah 5 kali! Silakan masukkan KODE DEV untuk verifikasi.')->withInput();
            }

            return back()->with('error', "❌ NISN yang Anda masukkan tidak cocok dengan data akun. Salah: {$newFailCount}/5 kali.")->withInput();
        }

        // 4. Berhasil Verifikasi -> Clear Counter & Generate Token
        RateLimiter::clear($throttleKey);
        session()->forget('nisn_fail_count');

        $token = Str::random(60);
        session(['reset_password_user_id' => $user->id, 'reset_password_token' => $token]);

        return redirect()->route('password.reset', ['token' => $token])
            ->with('success', "Identitas diverifikasi untuk akun {$user->name}. Silakan buat kata sandi baru.");
    }

    public function showResetForm($token)
    {
        if (session('reset_password_token') !== $token) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi reset password tidak valid atau sudah kadaluwarsa.');
        }

        return view('pages.auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $userId = session('reset_password_user_id');
        $sessionToken = session('reset_password_token');

        if (!$userId || $sessionToken !== $request->token) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi tidak valid.');
        }

        $user = User::findOrFail($userId);
        $user->password = $request->password; // Otomatis ter-hash oleh Cast Model User
        $user->save();

        session()->forget(['reset_password_user_id', 'reset_password_token']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.');
    }
}