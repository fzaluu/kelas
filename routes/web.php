<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\HomeroomTeacher\TeacherAttendanceController;
use App\Http\Controllers\Student\AttendanceController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'profile'])->name('public.about');

// Guest Routes (Auth)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Protected Route - Wali Kelas / Admin Absensi
    Route::middleware('permission:attendance.session.create')->prefix('teacher')->group(function () {
        Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('teacher.attendance.index');
        Route::post('/attendance', [TeacherAttendanceController::class, 'storeSession'])->name('teacher.attendance.store');
    });

    // Protected Route - Siswa Scan QR
    Route::middleware('permission:attendance.scan')->prefix('student')->group(function () {
        Route::get('/attendance/scan', [AttendanceController::class, 'showScanForm'])->name('student.attendance.scan');
        Route::post('/attendance/scan', [AttendanceController::class, 'processScan'])->name('student.attendance.scan.post');
    });

    // Protected Route - Role Development
    Route::middleware('role:development')->prefix('dev')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>Welcome to Development Dashboard!</h1><form action="'.route('logout').'" method="POST">'.csrf_field().'<button type="submit">Logout</button></form>';
        })->name('development.dashboard');
    });

    // Protected Route Contoh Permission
    Route::middleware('permission:attendance.scan')->get('/test-scan', function () {
        return 'Izin Scan Absensi Diverifikasi!';
    });
});