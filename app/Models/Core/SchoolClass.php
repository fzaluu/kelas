<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $guarded = ['id'];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'class_id'); // ✅ Diganti dari $table ke $this
    }

    public function classTeachers(): HasMany
    {
        return $this->hasMany(ClassTeacher::class, 'class_id');
    }

    public function classPositions(): HasMany
    {
        return $this->hasMany(ClassPosition::class, 'class_id');
    }
}