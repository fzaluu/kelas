<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassTeacher extends Model
{
    protected $guarded = ['id'];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function teacherUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}