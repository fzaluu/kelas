<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Core\SchoolClass;

class ClassProfile extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
        ];
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}