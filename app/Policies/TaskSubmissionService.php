<?php

namespace App\Services;

use App\Models\Academic\Task;
use App\Models\Academic\TaskSubmission;
use App\Models\Core\Member;
use App\Models\Core\ActivityLog;
use Carbon\Carbon;

class TaskSubmissionService
{
    /**
     * Membuat & Mempublikasikan Tugas Baru (Tanpa Pre-Create Row Not Started)
     */
    public function createTask(
        int $classId,
        int $subjectId,
        string $title,
        string $description,
        string $deadline,
        int $creatorUserId,
        ?string $instructions = null
    ): Task {
        $now = Carbon::now('Asia/Jakarta');

        $task = Task::create([
            'class_id' => $classId,
            'subject_id' => $subjectId,
            'title' => $title,
            'description' => $description,
            'instructions' => $instructions,
            'start_at' => $now,
            'deadline' => Carbon::parse($deadline, 'Asia/Jakarta'),
            'status' => 'PUBLISHED',
            'created_by' => $creatorUserId,
            'published_at' => $now,
        ]);

        // Audit Log
        ActivityLog::create([
            'actor_user_id' => $creatorUserId,
            'action' => 'task.publish',
            'resource_type' => 'task',
            'resource_id' => $task->id,
            'result' => 'SUCCESS',
        ]);

        return $task;
    }

    /**
     * Submit Tugas: Menambah/Mengubah Row saat Siswa Mengumpulkan
     */
    public function submitTask(int $taskId, int $authUserId, ?string $ip = null, ?string $userAgent = null): array
    {
        $task = Task::find($taskId);

        if (!$task || $task->status !== 'PUBLISHED') {
            return ['success' => false, 'message' => 'Tugas tidak ditemukan atau sudah ditutup.'];
        }

        $member = Member::where('id', function ($query) use ($authUserId) {
            $query->select('member_id')->from('users')->where('id', $authUserId);
        })->first();

        if (!$member) {
            return ['success' => false, 'message' => 'Akun Anda tidak terhubung dengan data siswa mana pun.'];
        }

        // Cari atau buat baru jika siswa pertama kali mengumpulkan
        $submission = TaskSubmission::firstOrNew([
            'task_id' => $taskId,
            'member_id' => $member->id,
        ]);

        if ($submission->status === 'GRADED') {
            return ['success' => false, 'message' => 'Tugas Anda sudah dinilai dan tidak dapat dikumpulkan ulang.'];
        }

        $now = Carbon::now('Asia/Jakarta');
        $isLate = $now->greaterThan($task->deadline);
        $newStatus = $isLate ? 'LATE' : 'SUBMITTED';

        $submission->submitted_at = $now;
        $submission->status = $newStatus;
        $submission->save();

        ActivityLog::create([
            'actor_user_id' => $authUserId,
            'action' => 'task.submit',
            'resource_type' => 'task_submission',
            'resource_id' => $submission->id,
            'result' => 'SUCCESS',
            'ip' => $ip,
            'user_agent' => $userAgent,
        ]);

        return [
            'success' => true,
            'message' => $isLate ? 'Tugas berhasil dikumpulkan (Terlambat).' : 'Tugas berhasil dikumpulkan tepat waktu.',
            'status' => $newStatus,
            'submitted_at' => $now->format('d M Y, H:i WIB'),
        ];
    }
}