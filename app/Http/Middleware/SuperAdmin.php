<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check if user is level
        if (!auth()->user()->superAdmin) {
            if (!auth()->user()->admin) {
                return response()->redirectToRoute('sales');
            }
            return response()->redirectToRoute('home')->with('warning', 'Unauthorized access.');
        }
        return $next($request);
    }
}
