<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

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

    // 📢 1. Pengumuman
    public function announcements()
    {
        $classId = 1;
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

    // 📅 2. Agenda
    public function agendas()
    {
        $classId = 1;
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

    // 📚 3. Tugas Publik
    public function tasks()
    {
        $classId = 1;
        $TaskModel = $this->getModelClass('Task', 'Academic');

        $activeTasks = collect();
        if ($TaskModel) {
            $deadlineColumn = \Illuminate\Support\Facades\Schema::hasColumn('tasks', 'deadline') ? 'deadline' : 'due_at';

            $activeTasks = $TaskModel::where('class_id', $classId)
                ->where('status', 'PUBLISHED')
                ->where($deadlineColumn, '>=', now())
                ->with('subject')
                ->withCount('submissions') // Menghitung otomatis jumlah pengumpulan siswa
                ->orderBy($deadlineColumn, 'asc')
                ->get();
        }

        return view('pages.public.information.tasks', compact('activeTasks'));
    }

    // 🗓️ 4. Jadwal (Pelajaran + Piket Unified)
    public function schedules()
    {
        $classId = 1;
        $ScheduleModel = $this->getModelClass('LessonSchedule', 'Academic');

        $schedules = collect();
        if ($ScheduleModel) {
            $schedules = $ScheduleModel::where('class_id', $classId)
                ->with(['subject', 'teacher'])
                ->get()
                ->groupBy('day_of_week');
        }

        return view('pages.public.information.schedules', compact('schedules'));
    }
}