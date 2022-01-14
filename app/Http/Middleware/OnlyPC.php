<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyPC
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

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Fetch mac address
            $pcMac = substr(exec('getmac'), 0, 17);
            if ($pcMac === "68-94-23-1C-18-82") {
                return $next($request);
            }

            auth()->logout();
            session()->flush();

            return response()->redirectToRoute('login')->with('error', 'Unauthorized');
        } else {
            return $next($request);
        }
    }
}
