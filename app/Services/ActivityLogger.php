<?php

namespace App\Services;

use App\Models\Core\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(
        string $action,
        string $resourceType,
        ?int $resourceId = null,
        string $result = 'SUCCESS',
        ?array $before = null,
        ?array $after = null,
        ?string $scope = null
    ): ActivityLog {
        return ActivityLog::create([
            'actor_user_id' => Auth::id(),
            'action'        => $action,
            'resource_type' => $resourceType,
            'resource_id'   => $resourceId,
            'scope'         => $scope,
            'before'        => $before,
            'after'         => $after,
            'result'        => $result,
            'ip'            => Request::ip(),
            'user_agent'    => Request::userAgent(),
        ]);
    }
}