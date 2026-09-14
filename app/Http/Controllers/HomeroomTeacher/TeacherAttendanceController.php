<?php

namespace App\Http\Controllers\HomeroomTeacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance\AttendanceSession;
use App\Models\Attendance\AttendanceRecord;
use App\Models\Core\Member;
use App\Services\AttendanceQRService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TeacherAttendanceController extends Controller
{
    protected AttendanceQRService $attendanceService;

    public function __construct(AttendanceQRService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        $classId = Auth::user()->member->class_id ?? 1;

        $sessions = AttendanceSession::where('class_id', $classId)
            ->with('creator')
            ->orderBy('id', 'desc')
            ->get();

        $activeSession = AttendanceSession::where('class_id', $classId)
            ->where('status', 'OPEN')
            ->orderBy('id', 'desc')
            ->first();

        $activeToken = session('raw_token', $activeSession->raw_token ?? null);

        return view('pages.homeroom-teacher.attendance.index', compact('sessions', 'activeSession', 'activeToken'));
    }

    public function storeSession(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5|max:480',
        ]);

        $classId = Auth::user()->member->class_id ?? 1;

        $session = $this->attendanceService->createSession(
            $classId,
            $request->title,
            (int) $request->duration_minutes,
            Auth::id()
        );

        return back()->with([
            'success' => 'Sesi absensi "' . $session->title . '" berhasil dibuka!',
            'raw_token' => $session->raw_token,
        ]);
    }

    /**
     * Tutup Sesi Absensi Secara Manual
     */
    public function closeSession($id)
    {
        $session = AttendanceSession::findOrFail($id);

        if ($session->status === 'OPEN') {
            $session->update([
                'status' => 'CLOSED',
                'closed_at' => Carbon::now('Asia/Jakarta'),
            ]);
        }

        return back()->with('success', 'Sesi absensi "' . $session->title . '" telah ditutup secara manual.');
    }

    /**
     * Halaman Rekap Matriks Absensi & Input Manual
     */
    public function recap(Request $request)
    {
        $classId = Auth::user()->member->class_id ?? 1;

        // Ambil seluruh sesi absensi kelas ini
        $sessions = AttendanceSession::where('class_id', $classId)
            ->orderBy('id', 'asc')
            ->get();

        // Tentukan sesi yang dipilih (Default: Sesi Terakhir / Hari Ini)
        $selectedSessionId = $request->input('session_id', $sessions->last()->id ?? null);
        $selectedSession = $sessions->firstWhere('id', $selectedSessionId);

        // Ambil seluruh daftar siswa di kelas tersebut
        $members = Member::where('class_id', $classId)
            ->where('member_status', 'ACTIVE')
            ->orderBy('name', 'asc')
            ->get();

        // Ambil seluruh record absensi untuk mapping matriks
        $records = AttendanceRecord::whereIn('attendance_session_id', $sessions->pluck('id'))
            ->get()
            ->groupBy(['member_id', 'attendance_session_id']);

        return view('pages.homeroom-teacher.recap.index', compact('sessions', 'selectedSession', 'selectedSessionId', 'members', 'records'));
    }

    /**
     * Input / Update Manual Status Absensi Siswa oleh Wali Kelas
     */
    public function updateManual(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:attendance_sessions,id',
            'member_id' => 'required|exists:members,id',
            'status' => 'required|in:HADIR,TERLAMBAT,SAKIT,IZIN,ALPA',
        ]);

        AttendanceRecord::updateOrCreate(
            [
                'attendance_session_id' => $request->session_id,
                'member_id' => $request->member_id,
            ],
            [
                'status' => $request->status,
                'method' => 'MANUAL',
                'recorded_by' => Auth::id(),
            ]
        );

        return back()->with('success', 'Status presensi berhasil diperbarui secara manual!');
    }
}