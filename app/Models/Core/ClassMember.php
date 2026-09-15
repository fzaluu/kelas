<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassMember extends Model
{
    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'full_name',
        'gender',
        'pob',
        'dob',
        'address',
        'avatar_path',
        'status',
    ];

    /**
     * Relasi ke akun User (Opsional)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}