<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin') || session()->get('admin')['role_id'] !== 1) {
            return redirect()->route('admin.login')->with('error', 'Please login as admin first');
        }

        return $next($request);
    }
}
