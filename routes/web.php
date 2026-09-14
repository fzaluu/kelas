<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\HomeroomTeacher\TeacherAttendanceController;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\InformationController;
use App\Http\Controllers\Public\GalleryController;

// Public Routes

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'profile'])->name('public.about');
Route::get('/contact', [ContactController::class, 'index'])->name('public.contact');
Route::post('/contact', [ContactController::class, 'submitFeedback'])->name('public.contact.submit');

// Information Public Routes
Route::prefix('information')->group(function () {
    Route::get('/announcements', [InformationController::class, 'announcements'])->name('public.information.announcements');
    Route::get('/agendas', [InformationController::class, 'agendas'])->name('public.information.agendas');
    Route::get('/tasks', [InformationController::class, 'tasks'])->name('public.information.tasks');
    Route::get('/schedules', [InformationController::class, 'schedules'])->name('public.information.schedules');
});

// Gallery Public Routes
Route::prefix('gallery')->group(function () {
    Route::get('/activities', [GalleryController::class, 'activities'])->name('public.gallery.activities');
    Route::get('/projects', [GalleryController::class, 'projects'])->name('public.gallery.projects');
    Route::get('/appreciations', [GalleryController::class, 'appreciations'])->name('public.gallery.appreciations');
});
// Guest Routes (Auth)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Protected Route - Wali Kelas / Admin Absensi
    Route::middleware('permission:attendance.session.create')->prefix('teacher')->name('teacher.attendance.')->group(function () {
        Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('index');
        Route::post('/attendance', [TeacherAttendanceController::class, 'storeSession'])->name('store');
        Route::post('/attendance/{id}/close', [TeacherAttendanceController::class, 'closeSession'])->name('close');
        
        // 👇 ROUTE REKAP & INPUT MANUAL BARU
        Route::get('/attendance/recap', [TeacherAttendanceController::class, 'recap'])->name('recap');
        Route::post('/attendance/manual', [TeacherAttendanceController::class, 'updateManual'])->name('manual');
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