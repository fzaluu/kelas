<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->hasPermission($permission)) {
            return $next($request);
        }

        abort(403, 'Akses Ditolak: Anda tidak memiliki izin (permission) untuk melakukan aksi ini.');
    }
}