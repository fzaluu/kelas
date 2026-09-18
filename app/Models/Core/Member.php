<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Media\MediaFile;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'class_id',
        'nis',
        'nisn',
        'name',
        'photo_file_id',
        'gender',
        'public_bio',
        'public_status',
        'member_status',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'joined_at' => 'date',
        'left_at'   => 'date',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'member_id');
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'photo_file_id');
    }

    public function positions(): HasMany
    {
        return $this->hasMany(ClassPosition::class, 'member_id');
    }
}