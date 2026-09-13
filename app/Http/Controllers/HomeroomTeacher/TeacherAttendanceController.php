<?php

namespace App\Http\Controllers\HomeroomTeacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance\AttendanceSession;
use App\Services\AttendanceQRService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAttendanceController extends Controller
{
    protected AttendanceQRService $attendanceService;

    public function __construct(AttendanceQRService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        $sessions = AttendanceSession::with('creator')->orderBy('id', 'desc')->get();
        return view('pages.homeroom-teacher.attendance.index', compact('sessions'));
    }

    public function storeSession(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5|max:480',
        ]);

        // Default Class ID 1 (Sesuai Seeder XI PPLG 2)
        $classId = 1;

        $session = $this->attendanceService->createSession(
            $classId,
            $request->title,
            (int) $request->duration_minutes,
            Auth::id()
        );

        return back()->with('success', 'Sesi absensi "' . $session->title . '" berhasil dibuka! Token sementara: ' . $session->raw_token);
    }
}