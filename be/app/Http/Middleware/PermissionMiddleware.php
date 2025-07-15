<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $E403 = true;
        foreach ($guards as $guard) {
            if (Gate::check(trim($guard))) {
                $E403 = false;
                break;
            }
        }
        abort_if($E403, 403, trans('custom.authorization.not_has_access'));
        return $next($request);
    }
}
