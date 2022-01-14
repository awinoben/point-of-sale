<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use App\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Get home view
     * @return Factory|View
     */
    public function welcome()
    {
        // Test database connection
        try {
            DB::connection()->getPdo();
            return \view('auth.login');
        } catch (Exception $e) {
            return view('auth.start-xampp');
        }
    }

    /**
     * start xampp here
     */
    public function xamppStart()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //execute xampp start/start xampp here
            shell_exec("C:/xampp/xampp_start.exe");
            return redirect()->route('welcome')->with('success', 'Server has been started. Proceed...');
        } else {
            return redirect()->route('welcome')->with('info', 'Server is already running...');
        }
    }

    /**
     * Reset password page
     * @return Factory|View
     */
    public function resetPasswordPage()
    {
        return \view('auth.forgot-password');
    }

    /**
     * Reset password here
     * @param PasswordResetRequest $request
     * @return RedirectResponse
     */
    public function resetPassword(PasswordResetRequest $request)
    {
        $user = User::query()->where('pin', $request->pin)->first();
        if ($user) {
            $user->update([
                'password' => bcrypt($request->passsword),
            ]);

            auth()->loginUsingId($user->id);
            return redirect()->intended('home')->with('success', 'Password reset was successful.');

        }
        return redirect()->back()->with('error', 'Wrong PIN.');
    }

    /**
     * Get mac address here
     * @return void
     */
    public function macAddress()
    {
        $shellexec = substr(exec('getmac'), 0, 17);
        dd($shellexec);
    }
}
