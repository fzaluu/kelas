<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Core\Member;
use App\Models\Core\User;

class AttendanceRecord extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'check_in_at' => 'datetime',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class, 'attendance_session_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function corrections(): HasMany
    {
        return $this->hasMany(AttendanceCorrection::class, 'attendance_record_id');
    }
}