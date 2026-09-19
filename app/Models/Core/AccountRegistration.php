<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountRegistration extends Model
{
    use HasFactory;

    protected $table = 'account_registrations';

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'nis',
        'nisn',
        'gender',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
            'password'    => 'hashed',
        ];
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}