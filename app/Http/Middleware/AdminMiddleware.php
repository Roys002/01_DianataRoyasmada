<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || $request->user()->role !== 'admin') {
            // jika request AJAX/API kembalikan json, else redirect ke login admin
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden, admin only.'], 403);
            }
            return redirect()->route('admin.login.form')->with('error', 'Silakan login sebagai admin.');
        }
        return $next($request);
    }
}
