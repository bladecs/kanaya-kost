<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // Cek apakah user login dan email-nya admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        // Kalau bukan admin, redirect
        return redirect('/')->with('error', 'Access denied. Admin only.');
    }
}

