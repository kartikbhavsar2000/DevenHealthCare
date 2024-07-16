<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Log;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route() ? $request->route()->getName() : 'undefined';
        $usereName = Auth::user()->name ?? "undefined"; 

        if( Auth::check() )
        {
            Log::info('User: '. $usereName . ' , Route: ' . $routeName . ' loaded');
            return $next($request);
        }
        Log::info('User: '. $usereName . ' , Route: ' . $routeName . ' loaded');
        Log::info('User: '. $usereName . ' , Route: ' . $routeName . ' Permission Denied');
        return redirect('login');
    }
}
