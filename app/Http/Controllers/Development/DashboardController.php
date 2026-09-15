<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Development Dashboard Overview.
     */
    public function index()
    {
        // 1. Total Akun
        $totalUsers = User::count();

        // 2. Hitung statistik user berdasarkan relasi Role (menggunakan whereHas)
        $userRolesCount = [
            'siswa'     => User::whereHas('roles', fn($q) => $q->where('name', 'siswa'))->count(),
            'pengurus'  => User::whereHas('roles', fn($q) => $q->whereIn('name', ['ketuakelas', 'bendahara', 'sekretaris']))->count(),
            'walikelas' => User::whereHas('roles', fn($q) => $q->where('name', 'walikelas'))->count(),
            'developer' => User::whereHas('roles', fn($q) => $q->where('name', 'development'))->count(),
        ];

        return view('pages.development.dashboard', compact('totalUsers', 'userRolesCount'));
    }
}