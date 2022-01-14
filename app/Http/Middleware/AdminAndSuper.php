<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAndSuper
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
        if (!auth()->user()->admin && !auth()->user()->superAdmin) {
            return response()->redirectToRoute('sales');
        }
        return $next($request);
    }
}
