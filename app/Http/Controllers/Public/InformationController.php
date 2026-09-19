<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Academic\Schedule;
use App\Models\Academic\Piket;
use App\Models\Core\SchoolClass;

class InformationController extends Controller
{
    private function getModelClass(string $name, string $subfolder = '')
    {
        $namespacedWithFolder = "App\\Models\\{$subfolder}\\{$name}";
        if (class_exists($namespacedWithFolder)) {
            return $namespacedWithFolder;
        }

        $namespacedDirect = "App\\Models\\{$name}";
        if (class_exists($namespacedDirect)) {
            return $namespacedDirect;
        }

        return null;
    }

    // 1. Pengumuman
    public function announcements()
    {
        $classId = SchoolClass::getActiveId(); // ✅ Dinamis via SchoolClass
        $AnnouncementModel = $this->getModelClass('Announcement', 'Content');

        $announcements = collect();
        if ($AnnouncementModel) {
            $announcements = $AnnouncementModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->orderBy('published_at', 'desc')
                ->paginate(9);
        }

        return view('pages.public.information.announcements', compact('announcements'));
    }

    // 2. Agenda
    public function agendas()
    {
        $classId = SchoolClass::getActiveId(); // ✅ Dinamis via SchoolClass
        $AgendaModel = $this->getModelClass('Agenda', 'Content');

        $upcomingAgendas = collect();
        $pastAgendas = collect();

        if ($AgendaModel) {
            $upcomingAgendas = $AgendaModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('start_at', '>=', now())
                ->orderBy('start_at', 'asc')
                ->get();

            $pastAgendas = $AgendaModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where('start_at', '<', now())
                ->orderBy('start_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('pages.public.information.agendas', compact('upcomingAgendas', 'pastAgendas'));
    }

    // 3. Tugas Publik
    public function tasks()
    {
        $classId = SchoolClass::getActiveId(); // ✅ Dinamis via SchoolClass
        $TaskModel = $this->getModelClass('Task', 'Academic');

        $activeTasks = collect();
        if ($TaskModel) {
            $deadlineColumn = \Illuminate\Support\Facades\Schema::hasColumn('tasks', 'deadline') ? 'deadline' : 'due_at';

            $activeTasks = $TaskModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where($deadlineColumn, '>=', now())
                ->with('subject')
                ->withCount('submissions')
                ->orderBy($deadlineColumn, 'asc')
                ->get();
        }

        return view('pages.public.information.tasks', compact('activeTasks'));
    }

    // 4. Jadwal (Pelajaran + Piket Dinamis)
    public function schedules()
    {
        $classId = SchoolClass::getActiveId(); // ✅ Dinamis via SchoolClass

        // Ambil Jadwal Pelajaran
        $schedules = Schedule::where('class_id', $classId)
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        // Ambil Jadwal Piket Kebersihan
        $pikets = Piket::where('class_id', $classId)
            ->get()
            ->groupBy('day');

        return view('pages.public.information.schedules', compact('schedules', 'pikets'));
    }
}