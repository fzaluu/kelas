<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Development\DashboardController as DevDashboardController;
use App\Http\Controllers\Development\UserController as DevUserController;
use App\Http\Controllers\Development\RoleController as DevRoleController;
use App\Http\Controllers\Development\MemberController as DevMemberController;
use App\Http\Controllers\Development\ApprovalController as DevApprovalController;
use App\Http\Controllers\Development\MediaController as DevMediaController;
use App\Http\Controllers\Development\ActivityLogController as DevActivityLogController;
use App\Http\Controllers\Development\AnnouncementController as DevAnnouncementController;
use App\Http\Controllers\Development\AgendaController as DevAgendaController;
use App\Http\Controllers\Development\ClassDocumentController as DevClassDocumentController;
use App\Http\Controllers\Development\GalleryController as DevGalleryController;
use App\Http\Controllers\Development\ProjectController as DevProjectController;
use App\Http\Controllers\Development\AppreciationController as DevAppreciationController;
use App\Http\Controllers\Development\ScheduleController as DevScheduleController;
use App\Http\Controllers\Development\TaskController as DevTaskController;
use App\Http\Controllers\Development\ContactMessageController as DevContactMessageController;
use App\Http\Controllers\Development\SystemSettingController as DevSystemSettingController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\InformationController;
use App\Http\Controllers\Public\GalleryController;
use App\Http\Controllers\HomeroomTeacher\TeacherAttendanceController;
use App\Http\Controllers\Student\AttendanceController;

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

// Guest Routes (Login, Register & Password Recovery)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register Mandiri
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    // Password Recovery
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Development Area
    Route::middleware('role:development')->prefix('dev')->group(function () {
        Route::get('/dashboard', [DevDashboardController::class, 'index'])->name('development.dashboard');

        // User & Akses
        Route::resource('users', DevUserController::class)->except(['show'])->names('development.users');

        // Persetujuan Akun Pendaftaran
        Route::get('/approvals', [DevApprovalController::class, 'index'])->name('development.approvals.index');
        Route::post('/approvals/{id}/approve', [DevApprovalController::class, 'approve'])->name('development.approvals.approve');
        Route::post('/approvals/{id}/reject', [DevApprovalController::class, 'reject'])->name('development.approvals.reject');

        // Role & Permission
        Route::get('/roles', [DevRoleController::class, 'index'])->name('development.roles.index');
        Route::get('/roles/{role}/edit', [DevRoleController::class, 'edit'])->name('development.roles.edit');
        Route::put('/roles/{role}', [DevRoleController::class, 'update'])->name('development.roles.update');

        // Anggota Kelas
        Route::resource('members', DevMemberController::class)->except(['show'])->names('development.members');

        // Modul Akademik & Jadwal / Tugas
        Route::prefix('akademik')->name('development.academic.')->group(function () {
            Route::get('/schedules', [DevScheduleController::class, 'index'])->name('schedules.index');
            Route::post('/schedules', [DevScheduleController::class, 'storeSchedule'])->name('schedules.store');
            Route::delete('/schedules/{schedule}', [DevScheduleController::class, 'destroySchedule'])->name('schedules.destroy');

            Route::post('/piket', [DevScheduleController::class, 'storePiket'])->name('piket.store');
            Route::delete('/piket/{piket}', [DevScheduleController::class, 'destroyPiket'])->name('piket.destroy');

            // Manajemen Tugas
            Route::resource('tasks', DevTaskController::class)->except(['show', 'edit', 'update']);
        });

        // Media Manager
        Route::get('/media', [DevMediaController::class, 'index'])->name('development.media.index');
        Route::post('/media', [DevMediaController::class, 'store'])->name('development.media.store');
        Route::put('/media/{medium}', [DevMediaController::class, 'update'])->name('development.media.update');
        Route::delete('/media/{medium}', [DevMediaController::class, 'destroy'])->name('development.media.destroy');

        // Activity Log
        Route::get('/activity-logs', [DevActivityLogController::class, 'index'])->name('development.activity-logs.index');

        // CMS Publik
        Route::prefix('publik')->name('development.public.')->group(function () {
            Route::resource('announcements', DevAnnouncementController::class)->except(['show', 'edit', 'update']);
            Route::resource('agendas', DevAgendaController::class)->except(['show', 'edit', 'update']);
            Route::resource('documents', DevClassDocumentController::class)->except(['show', 'edit', 'update']);
            Route::resource('galleries', DevGalleryController::class)->except(['show', 'edit', 'update']);

            // Pesan Masukan Kontak
            Route::get('/messages', [DevContactMessageController::class, 'index'])->name('messages.index');
            Route::delete('/messages/{id}', [DevContactMessageController::class, 'destroy'])->name('messages.destroy');
        });

        // CMS Khusus Karya & Prestasi (Di bawah namespace development.content)
        Route::prefix('content')->group(function () {
            Route::resource('projects', DevProjectController::class)->except(['show', 'edit', 'update'])->names([
                'index'   => 'development.content.projects.index',
                'create'  => 'development.content.projects.create',
                'store'   => 'development.content.projects.store',
                'destroy' => 'development.content.projects.destroy',
            ]);

            Route::resource('appreciations', DevAppreciationController::class)->except(['show', 'edit', 'update'])->names([
                'index'   => 'development.content.appreciations.index',
                'create'  => 'development.content.appreciations.create',
                'store'   => 'development.content.appreciations.store',
                'destroy' => 'development.content.appreciations.destroy',
            ]);
        });

        // Pengaturan Sistem
        Route::prefix('system')->name('development.system.')->group(function () {
            Route::get('/settings', [DevSystemSettingController::class, 'index'])->name('settings.index');
            Route::post('/settings', [DevSystemSettingController::class, 'update'])->name('settings.update');
        });
    });

    // Wali Kelas Area
    Route::middleware('permission:attendance.session.create')->prefix('teacher')->name('teacher.attendance.')->group(function () {
        Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('index');
        Route::post('/attendance', [TeacherAttendanceController::class, 'storeSession'])->name('store');
        Route::post('/attendance/{id}/close', [TeacherAttendanceController::class, 'closeSession'])->name('close');
        Route::get('/attendance/recap', [TeacherAttendanceController::class, 'recap'])->name('recap');
        Route::post('/attendance/manual', [TeacherAttendanceController::class, 'updateManual'])->name('manual');
    });

    // Siswa Area
    Route::middleware('permission:attendance.scan')->prefix('student')->group(function () {
        Route::get('/attendance/scan', [AttendanceController::class, 'showScanForm'])->name('student.attendance.scan');
        Route::post('/attendance/scan', [AttendanceController::class, 'processScan'])->name('student.attendance.scan.post');
    });
});