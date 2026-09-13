<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ScanQRRequest;
use App\Models\Attendance\AttendanceSession;
use App\Services\AttendanceQRService;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected AttendanceQRService $attendanceService;

    public function __construct(AttendanceQRService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function showScanForm()
    {
        $activeSession = AttendanceSession::where('status', 'OPEN')->orderBy('id', 'desc')->first();
        return view('pages.student.attendance.scan', compact('activeSession'));
    }

    public function processScan(ScanQRRequest $request)
    {
        $result = $this->attendanceService->scanQR(
            (int) $request->session_id,
            $request->scanned_token,
            Auth::id(),
            $request->ip(),
            $request->userAgent()
        );

        if (!$result['success']) {
            return back()->withErrors(['scan' => $result['message']]);
        }

        return back()->with('success', $result['message']);
    }
}