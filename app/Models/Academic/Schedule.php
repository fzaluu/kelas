<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'day',
        'subject_name',
        'teacher_name',
        'start_time',
        'end_time',
        'room',
    ];
}