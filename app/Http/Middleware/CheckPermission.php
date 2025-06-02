<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission, $feature = null)
    {
        if (!$request->user()->hasPermissionTo($permission, $feature)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
