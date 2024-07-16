<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // Log the user name and the route name after successful authentication
        Log::info('User logged in: ' . $user->name);

        // Optionally redirect to a different page
        return redirect()->intended($this->redirectTo);
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();

        // Perform the default logout
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Log the user name and the route name after successful logout
        Log::info('User logged out: ' . $user->name);

        return redirect('/');
    }
}
