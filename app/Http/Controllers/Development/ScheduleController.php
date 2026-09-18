<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Academic\Schedule;
use App\Models\Academic\Piket;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $days = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];

        $schedules = Schedule::orderBy('day')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        $pikets = Piket::orderBy('day')->get()->groupBy('day');

        return view('pages.development.academic.schedules.index', compact('days', 'schedules', 'pikets'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'day'          => ['required', 'in:SENIN,SELASA,RABU,KAMIS,JUMAT'],
            'subject_name' => ['required', 'string', 'max:255'],
            'teacher_name' => ['nullable', 'string', 'max:255'],
            'start_time'   => ['required'],
            'end_time'     => ['required', 'after:start_time'],
            'room'         => ['nullable', 'string', 'max:100'],
        ]);

        Schedule::create([
            'class_id'     => 1,
            'day'          => $request->day,
            'subject_name' => $request->subject_name,
            'teacher_name' => $request->teacher_name,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'room'         => $request->room ?? 'Lab PPLG 2',
        ]);

        return redirect()->route('development.academic.schedules.index')
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan!');
    }

    public function destroySchedule(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('development.academic.schedules.index')
            ->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }

    public function storePiket(Request $request)
    {
        $request->validate([
            'day'          => ['required', 'in:SENIN,SELASA,RABU,KAMIS,JUMAT'],
            'student_name' => ['required', 'string', 'max:255'],
        ]);

        Piket::create([
            'class_id'     => 1,
            'day'          => $request->day,
            'student_name' => $request->student_name,
        ]);

        return redirect()->route('development.academic.schedules.index')
            ->with('success', 'Anggota piket berhasil ditambahkan!');
    }

    public function destroyPiket(Piket $piket)
    {
        $piket->delete();

        return redirect()->route('development.academic.schedules.index')
            ->with('success', 'Anggota piket berhasil dihapus.');
    }
}