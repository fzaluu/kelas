<?php

namespace App\Models\Media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    use HasFactory;

    protected $table = 'media_files';
    protected $guarded = ['id'];

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->storage_disk)->url($this->storage_path);
    }

    public function uploader(): BelongsTo
    {
        // ✅ Tunjuk langsung ke Class User yang ada di Core
        return $this->belongsTo(\App\Models\Core\User::class, 'uploaded_by');
    }
}