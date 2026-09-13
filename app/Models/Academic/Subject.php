<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Core\SchoolClass;

class Subject extends Model
{
    protected $guarded = ['id'];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'subject_id');
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class, 'subject_id');
    }

    public function lessonSchedules(): HasMany
    {
        return $this->hasMany(LessonSchedule::class, 'subject_id');
    }

    public function examSchedules(): HasMany
    {
        return $this->hasMany(ExamSchedule::class, 'subject_id');
    }
}