<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfStaff
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
        if (!auth()->user()->group->is_staff_group) {
            return redirect('/')->with('error', 'You must be a staff member to access that page!');
        }

        return $next($request);
    }
}
