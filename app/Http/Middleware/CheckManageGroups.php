<?php

namespace App\Http\Middleware;

use Closure;

class CheckManageGroups
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!userHasPermission('pl_manage_groups')) {
            return redirect('/admin')->with('error', 'Your group does not have permission to access that page!');
        }

        return $next($request);
    }
}
