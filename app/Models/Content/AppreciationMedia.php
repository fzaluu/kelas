<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Media\MediaFile;

class AppreciationMedia extends Model
{
    protected $table = 'appreciation_media';
    protected $guarded = ['id'];

    public function appreciation(): BelongsTo
    {
        return $this->belongsTo(Appreciation::class, 'appreciation_id');
    }

    public function mediaFile(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'media_file_id');
    }
}