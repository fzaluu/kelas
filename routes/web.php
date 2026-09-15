<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Development\DashboardController as DevDashboardController;
use App\Http\Controllers\Development\UserController as DevUserController;
use App\Http\Controllers\Development\RoleController as DevRoleController;
use App\Http\Controllers\Development\ClassMemberController as DevClassMemberController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\InformationController;
use App\Http\Controllers\Public\GalleryController;
use App\Http\Controllers\HomeroomTeacher\TeacherAttendanceController;
use App\Http\Controllers\Student\AttendanceController;

// 🌐 Public Routes
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

// 🔐 Guest Routes (Auth)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// 🔐 Authenticated Routes (Member Area)
Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // 🛠️ Protected Route - Role Development (Slice 01 - Slice 04)
    Route::middleware('role:development')->prefix('dev')->group(function () {
        Route::get('/dashboard', [DevDashboardController::class, 'index'])->name('development.dashboard');
        
        // 👥 Rute Modul User & Akses (Slice 02 CRUD User)
        Route::get('/users', [DevUserController::class, 'index'])->name('development.users.index');
        Route::get('/users/create', [DevUserController::class, 'create'])->name('development.users.create');
        Route::post('/users', [DevUserController::class, 'store'])->name('development.users.store');
        Route::get('/users/{user}/edit', [DevUserController::class, 'edit'])->name('development.users.edit');
        Route::put('/users/{user}', [DevUserController::class, 'update'])->name('development.users.update');
        Route::delete('/users/{user}', [DevUserController::class, 'destroy'])->name('development.users.destroy');

        // 🔐 Rute Modul Role & Permission (Slice 03 RBAC Matrix)
        Route::get('/roles', [DevRoleController::class, 'index'])->name('development.roles.index');
        Route::get('/roles/{role}/edit', [DevRoleController::class, 'edit'])->name('development.roles.edit');
        Route::put('/roles/{role}', [DevRoleController::class, 'update'])->name('development.roles.update');

        // 👨‍🎓 Rute Modul Anggota Kelas (Slice 04 CRUD Siswa)
        Route::get('/members', [DevClassMemberController::class, 'index'])->name('development.members.index');
        Route::get('/members/create', [DevClassMemberController::class, 'create'])->name('development.members.create');
        Route::post('/members', [DevClassMemberController::class, 'store'])->name('development.members.store');
        Route::get('/members/{member}/edit', [DevClassMemberController::class, 'edit'])->name('development.members.edit');
        Route::put('/members/{member}', [DevClassMemberController::class, 'update'])->name('development.members.update');
        Route::delete('/members/{member}', [DevClassMemberController::class, 'destroy'])->name('development.members.destroy');
    });

    // 👨‍🏫 Protected Route - Wali Kelas / Admin Absensi
    Route::middleware('permission:attendance.session.create')->prefix('teacher')->name('teacher.attendance.')->group(function () {
        Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('index');
        Route::post('/attendance', [TeacherAttendanceController::class, 'storeSession'])->name('store');
        Route::post('/attendance/{id}/close', [TeacherAttendanceController::class, 'closeSession'])->name('close');
        
        // Recap & Manual Input
        Route::get('/attendance/recap', [TeacherAttendanceController::class, 'recap'])->name('recap');
        Route::post('/attendance/manual', [TeacherAttendanceController::class, 'updateManual'])->name('manual');
    });

    // 👨‍🎓 Protected Route - Siswa Scan QR
    Route::middleware('permission:attendance.scan')->prefix('student')->group(function () {
        Route::get('/attendance/scan', [AttendanceController::class, 'showScanForm'])->name('student.attendance.scan');
        Route::post('/attendance/scan', [AttendanceController::class, 'processScan'])->name('student.attendance.scan.post');
    });

    // Protected Route Contoh Permission
    Route::middleware('permission:attendance.scan')->get('/test-scan', function () {
        return 'Izin Scan Absensi Diverifikasi!';
    });
});