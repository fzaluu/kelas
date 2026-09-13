<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $guarded = ['id'];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'member_id');
    }

    public function positions(): HasMany
    {
        return $this->hasMany(ClassPosition::class, 'member_id');
    }
}