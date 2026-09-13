<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\SchoolClass;
use App\Models\Core\Role;
use App\Models\Core\Permission;
use App\Models\Core\RolePermission;
use App\Models\Core\User;
use App\Models\Core\UserRole;
use Illuminate\Support\Facades\Hash;

class CoreSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Kelas Utama
        $class = SchoolClass::create([
            'name' => 'XI PPLG 2',
            'major' => 'Pengembangan Perangkat Lunak dan Gim',
            'academic_year' => '2025/2026',
            'status' => 'ACTIVE',
        ]);

        // 2. Seed Roles
        $roleDev = Role::create([
            'name' => 'Development',
            'slug' => 'development',
            'description' => 'Pengembang & Pengelola Platform Sistem',
            'is_system' => true,
        ]);

        $roleTeacher = Role::create([
            'name' => 'Wali Kelas',
            'slug' => 'homeroom_teacher',
            'description' => 'Wali Kelas & Pembimbing Akademik',
            'is_system' => true,
        ]);

        $roleStudent = Role::create([
            'name' => 'Siswa',
            'slug' => 'student',
            'description' => 'Anggota Kelas / Siswa',
            'is_system' => true,
        ]);

        // 3. Seed Master Permissions
        $permissions = [
            // Attendance Permissions
            ['name' => 'Scan Absensi', 'slug' => 'attendance.scan', 'resource' => 'attendance', 'action' => 'scan'],
            ['name' => 'Lihat Absensi Sendiri', 'slug' => 'attendance.view_own', 'resource' => 'attendance', 'action' => 'view_own'],
            ['name' => 'Monitor Absensi Kelas', 'slug' => 'attendance.monitor', 'resource' => 'attendance', 'action' => 'monitor'],
            ['name' => 'Buat Sesi Absensi', 'slug' => 'attendance.session.create', 'resource' => 'attendance', 'action' => 'session_create'],
            ['name' => 'Tutup Sesi Absensi', 'slug' => 'attendance.session.close', 'resource' => 'attendance', 'action' => 'session_close'],
            ['name' => 'Ajukan Koreksi Absensi', 'slug' => 'attendance.correction.request', 'resource' => 'attendance', 'action' => 'correction_request'],
            ['name' => 'Validasi Koreksi Absensi', 'slug' => 'attendance.correction.validate', 'resource' => 'attendance', 'action' => 'correction_validate'],
            ['name' => 'Rekap Absensi', 'slug' => 'attendance.recap', 'resource' => 'attendance', 'action' => 'recap'],

            // Task Permissions
            ['name' => 'Lihat Tugas', 'slug' => 'task.view', 'resource' => 'task', 'action' => 'view'],
            ['name' => 'Kumpul Tugas', 'slug' => 'task.submit', 'resource' => 'task', 'action' => 'submit'],
            ['name' => 'Buat Tugas', 'slug' => 'task.create', 'resource' => 'task', 'action' => 'create'],
            ['name' => 'Publikasi Tugas', 'slug' => 'task.publish', 'resource' => 'task', 'action' => 'publish'],
            ['name' => 'Nilai Tugas', 'slug' => 'task.grade', 'resource' => 'task', 'action' => 'grade'],

            // Finance Permissions
            ['name' => 'Lihat Keuangan', 'slug' => 'finance.view', 'resource' => 'finance', 'action' => 'view'],
            ['name' => 'Catat Pemasukan/Pengeluaran', 'slug' => 'finance.create', 'resource' => 'finance', 'action' => 'create'],
            ['name' => 'Laporan Keuangan', 'slug' => 'finance.report', 'resource' => 'finance', 'action' => 'report'],

            // System Permissions
            ['name' => 'Kelola System', 'slug' => 'system.manage', 'resource' => 'system', 'action' => 'manage'],
        ];

        foreach ($permissions as $p) {
            Permission::create($p);
        }

        // 4. Assign Permissions to Roles (Role Permission & Scope)
        
        // --- Role Student ---
        $studentPerms = ['attendance.scan', 'attendance.view_own', 'attendance.correction.request', 'task.view', 'task.submit'];
        foreach ($studentPerms as $slug) {
            $perm = Permission::where('slug', $slug)->first();
            RolePermission::create([
                'role_id' => $roleStudent->id,
                'permission_id' => $perm->id,
                'scope' => 'own',
            ]);
        }

        // --- Role Wali Kelas ---
        $teacherPerms = [
            'attendance.monitor' => 'class',
            'attendance.session.create' => 'class',
            'attendance.session.close' => 'class',
            'attendance.correction.validate' => 'class',
            'attendance.recap' => 'class',
            'task.view' => 'class',
            'task.create' => 'class',
            'task.publish' => 'class',
            'task.grade' => 'class',
            'finance.view' => 'class',
            'finance.report' => 'class',
        ];

        foreach ($teacherPerms as $slug => $scope) {
            $perm = Permission::where('slug', $slug)->first();
            RolePermission::create([
                'role_id' => $roleTeacher->id,
                'permission_id' => $perm->id,
                'scope' => $scope,
            ]);
        }

        // --- Role Development ---
        $allPerms = Permission::all();
        foreach ($allPerms as $perm) {
            RolePermission::create([
                'role_id' => $roleDev->id,
                'permission_id' => $perm->id,
                'scope' => 'all',
            ]);
        }

        // 5. Seed Initial User Development (Dev/Superadmin Account)
        $devUser = User::create([
            'member_id' => null,
            'username' => 'dev',
            'email' => 'dev@pplg.local',
            'password' => Hash::make('password123'),
            'status' => 'ACTIVE',
        ]);

        UserRole::create([
            'user_id' => $devUser->id,
            'role_id' => $roleDev->id,
            'assigned_at' => now(),
            'assigned_by' => null,
        ]);
    }
}