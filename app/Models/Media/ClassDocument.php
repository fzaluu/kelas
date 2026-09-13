<?php

namespace App\Models\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Core\SchoolClass;
use App\Models\Core\User;

class ClassDocument extends Model
{
    protected $guarded = ['id'];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function mediaFile(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'media_file_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}