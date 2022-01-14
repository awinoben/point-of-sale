<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Blocked
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
        //check if user is blocked
        if (auth()->user()->blocked) {
            auth()->logout();
            session()->flush();

            $message = 'Sorry you can\'t be able to access your account';

            toastr()->error($message, 'Account Status');
            return response()->redirectToRoute('login')->with('error', $message);
        }

        return $next($request);
    }
}
