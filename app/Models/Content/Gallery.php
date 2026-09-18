<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Core\SchoolClass;
use App\Models\Core\User;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = [
        'class_id',
        'title',
        'description',
        'category',
        'status',
        'visibility',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi Album (1 Album Gallery menampung banyak Media)
     */
    public function galleryMedia(): HasMany
    {
        return $this->hasMany(GalleryMedia::class, 'gallery_id')->orderBy('sort_order', 'asc');
    }
}