<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Development\DashboardController as DevDashboardController;
use App\Http\Controllers\Development\UserController as DevUserController;
use App\Http\Controllers\Development\RoleController as DevRoleController;
use App\Http\Controllers\Development\ClassMemberController as DevClassMemberController;
use App\Http\Controllers\Development\ApprovalController as DevApprovalController;
use App\Http\Controllers\Development\MediaController as DevMediaController;
use App\Http\Controllers\Development\ActivityLogController as DevActivityLogController;
use App\Http\Controllers\Development\AnnouncementController as DevAnnouncementController;
use App\Http\Controllers\Development\AgendaController as DevAgendaController;
use App\Http\Controllers\Development\ClassDocumentController as DevClassDocumentController;
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

// 🔐 Guest Routes (Auth, Self-Registration & Forgot Password)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // 📝 Pendaftaran Mandiri Anggota
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    // 🔑 Lupa Password & Reset Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');
});

// 🚪 Direct / Emergency Logout Routes (Bisa GET & POST)
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔐 Authenticated Routes (Member Area)
Route::middleware('auth')->group(function () {

    // 🛠️ Protected Route - Role Development (Slice 01 - Slice 07)
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

        // 🛎️ Rute Modul Persetujuan Akun Pendaftaran (Approval Queue Gate)
        Route::get('/approvals', [DevApprovalController::class, 'index'])->name('development.approvals.index');
        Route::post('/approvals/{id}/approve', [DevApprovalController::class, 'approve'])->name('development.approvals.approve');
        Route::post('/approvals/{id}/reject', [DevApprovalController::class, 'reject'])->name('development.approvals.reject');

        // 📁 Rute Modul Media Manager
        Route::get('/media', [DevMediaController::class, 'index'])->name('development.media.index');
        Route::post('/media', [DevMediaController::class, 'store'])->name('development.media.store');
        Route::put('/media/{medium}', [DevMediaController::class, 'update'])->name('development.media.update'); // 👈 Tambahkan ini
        Route::delete('/media/{medium}', [DevMediaController::class, 'destroy'])->name('development.media.destroy');
        
        // 📋 Rute Modul Activity Log (Slice 06 Audit Trail)
        Route::get('/activity-logs', [DevActivityLogController::class, 'index'])->name('development.activity-logs.index');

        // 🌐 Rute Modul CMS / Konten Website (Slice 07 - Sub-prefix /dev/publik)
        Route::prefix('publik')->name('development.public.')->group(function () {
            // 📢 1. Pengumuman Kelas
            Route::get('/announcements', [DevAnnouncementController::class, 'index'])->name('announcements.index');
            Route::get('/announcements/create', [DevAnnouncementController::class, 'create'])->name('announcements.create');
            Route::post('/announcements', [DevAnnouncementController::class, 'store'])->name('announcements.store');
            Route::delete('/announcements/{announcement}', [DevAnnouncementController::class, 'destroy'])->name('announcements.destroy');

            // 📅 2. Agenda Kegiatan Kelas
            Route::get('/agendas', [DevAgendaController::class, 'index'])->name('agendas.index');
            Route::get('/agendas/create', [DevAgendaController::class, 'create'])->name('agendas.create');
            Route::post('/agendas', [DevAgendaController::class, 'store'])->name('agendas.store');
            Route::delete('/agendas/{agenda}', [DevAgendaController::class, 'destroy'])->name('agendas.destroy');

            // 📄 3. Dokumentasi & Arsip File
            Route::get('/documents', [DevClassDocumentController::class, 'index'])->name('documents.index');
            Route::get('/documents/create', [DevClassDocumentController::class, 'create'])->name('documents.create');
            Route::post('/documents', [DevClassDocumentController::class, 'store'])->name('documents.store');
            Route::delete('/documents/{document}', [DevClassDocumentController::class, 'destroy'])->name('documents.destroy');
        });
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