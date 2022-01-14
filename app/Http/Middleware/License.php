<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SystemController;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class License
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
        try {
            DB::connection()->getPdo();

            $timer = SystemController::fetchLicense();
            if (!Hash::check(config('timer.secret_key') . $timer->period, $timer->secret)) {
                if (Auth::check()) {
                    auth()->logout();
                    session()->flush();
                }

                return response()->view('auth.license');
            } elseif ($timer->period < now()) {
                if (Auth::check()) {
                    auth()->logout();
                    session()->flush();
                }

                return response()->view('auth.license');
            }
            return $next($request);
        } catch (Exception $e) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                shell_exec("C:/xampp/xampp_start.exe");
                return response()->redirectToRoute('login');
            }
        }
    }
}
