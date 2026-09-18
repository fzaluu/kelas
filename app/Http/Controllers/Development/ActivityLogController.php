<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('actor')->latest('created_at');

        // Filter Pencarian Action / Resource / Actor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('resource_type', 'like', "%{$search}%")
                  ->orWhereHas('actor', function ($actorQuery) use ($search) {
                      $actorQuery->where('username', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Result Status (SUCCESS, FAILED, FORBIDDEN)
        if ($request->filled('result')) {
            $query->where('result', $request->result);
        }

        $logs = $query->paginate(15)->withQueryString();

        return view('pages.development.activity-logs.index', compact('logs'));
    }
}