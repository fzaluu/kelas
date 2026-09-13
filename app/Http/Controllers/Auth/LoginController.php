<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Core\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Cek login via username atau email
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $attemptData = [
            $fieldType => $credentials['login'],
            'password' => $credentials['password'],
            'status' => 'ACTIVE',
        ];

        if (Auth::attempt($attemptData, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $user->update(['last_login_at' => now()]);

            // Catat Activity Log Login Berhasil
            ActivityLog::create([
                'actor_user_id' => $user->id,
                'action' => 'auth.login',
                'resource_type' => 'user',
                'resource_id' => $user->id,
                'result' => 'SUCCESS',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended(route('development.dashboard'));
        }

        // Catat Activity Log Login Gagal
        ActivityLog::create([
            'actor_user_id' => null,
            'action' => 'auth.login',
            'resource_type' => 'user',
            'resource_id' => null,
            'before' => ['attempted_login' => $credentials['login']],
            'result' => 'FAILED',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->withErrors([
            'login' => 'Kredensial yang diberikan tidak cocok dengan data kami atau akun Anda dinonaktifkan.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            ActivityLog::create([
                'actor_user_id' => $user->id,
                'action' => 'auth.logout',
                'resource_type' => 'user',
                'resource_id' => $user->id,
                'result' => 'SUCCESS',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}