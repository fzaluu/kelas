<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piket extends Model
{
    use HasFactory;

    protected $table = 'pikets';

    protected $fillable = [
        'class_id',
        'day',
        'student_name',
    ];
}