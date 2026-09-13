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
     * Membuat & Mempublikasikan Tugas Baru serta Menginisialisasi Record Submission Siswa
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

        // Inisialisasi record submission default NOT_STARTED untuk seluruh siswa aktif
        $members = Member::where('class_id', $classId)
            ->where('member_status', 'ACTIVE')
            ->get();

        foreach ($members as $member) {
            TaskSubmission::create([
                'task_id' => $task->id,
                'member_id' => $member->id,
                'status' => 'NOT_STARTED',
            ]);
        }

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
     * Submit / Mengumpulkan Tugas oleh Siswa
     */
    public function submitTask(int $taskId, int $authUserId, ?string $ip = null, ?string $userAgent = null): array
    {
        $task = Task::find($taskId);

        if (!$task || $task->status !== 'PUBLISHED') {
            return ['success' => false, 'message' => 'Tugas tidak ditemukan atau sudah ditutup.'];
        }

        // Ambil data member terikat
        $member = Member::where('id', function ($query) use ($authUserId) {
            $query->select('member_id')->from('users')->where('id', $authUserId);
        })->first();

        if (!$member) {
            return ['success' => false, 'message' => 'Akun Anda tidak terhubung dengan data siswa mana pun.'];
        }

        $submission = TaskSubmission::where('task_id', $taskId)
            ->where('member_id', $member->id)
            ->first();

        if (!$submission) {
            return ['success' => false, 'message' => 'Data pengumpulan tugas Anda tidak terdaftar.'];
        }

        if ($submission->status === 'GRADED') {
            return ['success' => false, 'message' => 'Tugas Anda sudah dinilai dan tidak dapat dikumpulkan ulang.'];
        }

        $now = Carbon::now('Asia/Jakarta');
        $isLate = $now->greaterThan($task->deadline);
        $newStatus = $isLate ? 'LATE' : 'SUBMITTED';

        $submission->update([
            'submitted_at' => $now,
            'status' => $newStatus,
        ]);

        // Audit Trail
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

    /**
     * Memberikan Nilai & Feedback pada Tugas Siswa
     */
    public function gradeSubmission(
        int $submissionId,
        float $grade,
        ?string $feedback,
        ?string $appreciation,
        int $graderUserId
    ): TaskSubmission {
        $submission = TaskSubmission::findOrFail($submissionId);

        $submission->update([
            'grade' => $grade,
            'feedback' => $feedback,
            'appreciation' => $appreciation,
            'status' => 'GRADED',
            'graded_by' => $graderUserId,
            'graded_at' => Carbon::now('Asia/Jakarta'),
        ]);

        // Audit Log
        ActivityLog::create([
            'actor_user_id' => $graderUserId,
            'action' => 'task.grade',
            'resource_type' => 'task_submission',
            'resource_id' => $submission->id,
            'result' => 'SUCCESS',
        ]);

        return $submission;
    }
}