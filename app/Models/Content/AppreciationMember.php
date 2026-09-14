<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Core\Member;

class AppreciationMember extends Model
{
    protected $guarded = ['id'];

    public function appreciation(): BelongsTo
    {
        return $this->belongsTo(Appreciation::class, 'appreciation_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}